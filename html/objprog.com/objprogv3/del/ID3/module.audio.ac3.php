<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.ac3.php                                        //
// module for analyzing AC-3 (aka Dolby Digital) audio files   //
// dependencies: NONE                                          //
//                                                            ///
/////////////////////////////////////////////////////////////////


class getid3_ac3 extends getid3_handler
{
    private $AC3header = array();
    private $BSIoffset = 0;

    const syncword = "\x0B\x77";

	public function Analyze() {
		$info = &$this->getid3->info;

		///AH
		$info['ac3']['raw']['bsi'] = array();
		$thisfile_ac3              = &$info['ac3'];
		$thisfile_ac3_raw          = &$thisfile_ac3['raw'];
		$thisfile_ac3_raw_bsi      = &$thisfile_ac3_raw['bsi'];


		// http://www.atsc.org/standards/a_52a.pdf

		$info['fileformat'] = 'ac3';

		// An AC-3 serial coded audio bit stream is made up of a sequence of synchronization frames
		// Each synchronization frame contains 6 coded audio blocks (AB), each of which represent 256
		// new audio samples per channel. A synchronization information (SI) header at the beginning
		// of each frame contains information needed to acquire and maintain synchronization. A
		// bit stream information (BSI) header follows SI, and contains parameters describing the coded
		// audio service. The coded audio blocks may be followed by an auxiliary data (Aux) field. At the
		// end of each frame is an error check field that includes a CRC word for error detection. An
		// additional CRC word is located in the SI header, the use of which, by a decoder, is optional.
		//
		// syncinfo() | bsi() | AB0 | AB1 | AB2 | AB3 | AB4 | AB5 | Aux | CRC

		// syncinfo() {
		// 	 syncword    16
		// 	 crc1        16
		// 	 fscod        2
		// 	 frmsizecod   6
		// } /* end of syncinfo */

		$this->fseek($info['avdataoffset']);
		$this->AC3header['syncinfo'] = $this->fread(5);

		if (strpos($this->AC3header['syncinfo'], self::syncword) === 0) {
			$thisfile_ac3_raw['synchinfo']['synchword'] = self::syncword;
			$offset = 2;
		} else {
			if (!$this->isDependencyFor('matroska')) {
				unset($info['fileformat'], $info['ac3']);
				return $this->error('Expecting "'.getid3_lib::PrintHexBytes(self::syncword).'" at offset '.$info['avdataoffset'].', found "'.getid3_lib::PrintHexBytes(substr($this->AC3header['syncinfo'], 0, 2)).'"');
			}
			$offset = 0;
			$this->fseek(-2, SEEK_CUR);
		}

		$info['audio']['dataformat']   = 'ac3';
		$info['audio']['bitrate_mode'] = 'cbr';
		$info['audio']['lossless']     = false;

		$thisfile_ac3_raw['synchinfo']['crc1']       = getid3_lib::LittleEndian2Int(substr($this->AC3header['syncinfo'], $offset, 2));
		$ac3_synchinfo_fscod_frmsizecod              = getid3_lib::LittleEndian2Int(substr($this->AC3header['syncinfo'], ($offset + 2), 1));
		$thisfile_ac3_raw['synchinfo']['fscod']      = ($ac3_synchinfo_fscod_frmsizecod & 0xC0) >> 6;
		$thisfile_ac3_raw['synchinfo']['frmsizecod'] = ($ac3_synchinfo_fscod_frmsizecod & 0x3F);

		$thisfile_ac3['sample_rate'] = self::sampleRateCodeLookup($thisfile_ac3_raw['synchinfo']['fscod']);
		if ($thisfile_ac3_raw['synchinfo']['fscod'] <= 3) {
			$info['audio']['sample_rate'] = $thisfile_ac3['sample_rate'];
		}

		$thisfile_ac3['frame_length'] = self::frameSizeLookup($thisfile_ac3_raw['synchinfo']['frmsizecod'], $thisfile_ac3_raw['synchinfo']['fscod']);
		$thisfile_ac3['bitrate']      = self::bitrateLookup($thisfile_ac3_raw['synchinfo']['frmsizecod']);
		$info['audio']['bitrate'] = $thisfile_ac3['bitrate'];

		$this->AC3header['bsi'] = getid3_lib::BigEndian2Bin($this->fread(15));
		$ac3_bsi_offset = 0;

		$thisfile_ac3_raw_bsi['bsid'] = $this->readHeaderBSI(5);
		if ($thisfile_ac3_raw_bsi['bsid'] > 8) {
			// Decoders which can decode version 8 will thus be able to decode version numbers less than 8.
			// If this standard is extended by the addition of additional elements or features, a value of bsid greater than 8 will be used.
			// Decoders built to this version of the standard will not be able to decode versions with bsid greater than 8.
			$this->error('Bit stream identification is version '.$thisfile_ac3_raw_bsi['bsid'].', but getID3() only understands up to version 8');
		    unset($info['ac3']);
			return false;
		}

		$thisfile_ac3_raw_bsi['bsmod'] = $this->readHeaderBSI(3);
		$thisfile_ac3_raw_bsi['acmod'] = $this->readHeaderBSI(3);

		$thisfile_ac3['service_type'] = self::serviceTypeLookup($thisfile_ac3_raw_bsi['bsmod'], $thisfile_ac3_raw_bsi['acmod']);
		$ac3_coding_mode = self::audioCodingModeLookup($thisfile_ac3_raw_bsi['acmod']);
		foreach($ac3_coding_mode as $key => $value) {
			$thisfile_ac3[$key] = $value;
		}
		switch ($thisfile_ac3_raw_bsi['acmod']) {
			case 0:
			case 1:
				$info['audio']['channelmode'] = 'mono';
				break;
			case 3:
			case 4:
				$info['audio']['channelmode'] = 'stereo';
				break;
			default:
				$info['audio']['channelmode'] = 'surround';
				break;
		}
		$info['audio']['channels'] = $thisfile_ac3['num_channels'];

		if ($thisfile_ac3_raw_bsi['acmod'] & 0x01) {
			// If the lsb of acmod is a 1, center channel is in use and cmixlev follows in the bit stream.
			$thisfile_ac3_raw_bsi['cmixlev'] = $this->readHeaderBSI(2);
			$thisfile_ac3['center_mix_level'] = self::centerMixLevelLookup($thisfile_ac3_raw_bsi['cmixlev']);
		}

		if ($thisfile_ac3_raw_bsi['acmod'] & 0x04) {
			// If the msb of acmod is a 1, surround channels are in use and surmixlev follows in the bit stream.
			$thisfile_ac3_raw_bsi['surmixlev'] = $this->readHeaderBSI(2);
			$thisfile_ac3['surround_mix_level'] = self::surroundMixLevelLookup($thisfile_ac3_raw_bsi['surmixlev']);
		}

		if ($thisfile_ac3_raw_bsi['acmod'] == 0x02) {
			// When operating in the two channel mode, this 2-bit code indicates whether or not the program has been encoded in Dolby Surround.
			$thisfile_ac3_raw_bsi['dsurmod'] = $this->readHeaderBSI(2);
			$thisfile_ac3['dolby_surround_mode'] = self::dolbySurroundModeLookup($thisfile_ac3_raw_bsi['dsurmod']);
		}

		$thisfile_ac3_raw_bsi['lfeon'] = (bool) $this->readHeaderBSI(1);
		$thisfile_ac3['lfe_enabled'] = $thisfile_ac3_raw_bsi['lfeon'];
		if ($thisfile_ac3_raw_bsi['lfeon']) {
			//$info['audio']['channels']++;
			$info['audio']['channels'] .= '.1';
		}

		$thisfile_ac3['channels_enabled'] = self::channelsEnabledLookup($thisfile_ac3_raw_bsi['acmod'], $thisfile_ac3_raw_bsi['lfeon']);

		// This indicates how far the average dialogue level is below digital 100 percent. Valid values are 1-31.
		// The value of 0 is reserved. The values of 1 to 31 are interpreted as -1 dB to -31 dB with respect to digital 100 percent.
		$thisfile_ac3_raw_bsi['dialnorm'] = $this->readHeaderBSI(5);
		$thisfile_ac3['dialogue_normalization'] = '-'.$thisfile_ac3_raw_bsi['dialnorm'].'dB';

		$thisfile_ac3_raw_bsi['compre_flag'] = (bool) $this->readHeaderBSI(1);
		if ($thisfile_ac3_raw_bsi['compre_flag']) {
			$thisfile_ac3_raw_bsi['compr'] = $this->readHeaderBSI(8);
			$thisfile_ac3['heavy_compression'] = self::heavyCompression($thisfile_ac3_raw_bsi['compr']);
		}

		$thisfile_ac3_raw_bsi['langcode_flag'] = (bool) $this->readHeaderBSI(1);
		if ($thisfile_ac3_raw_bsi['langcode_flag']) {
			$thisfile_ac3_raw_bsi['langcod'] = $this->readHeaderBSI(8);
		}

		$thisfile_ac3_raw_bsi['audprodie'] = (bool) $this->readHeaderBSI(1);
		if ($thisfile_ac3_raw_bsi['audprodie']) {
			$thisfile_ac3_raw_bsi['mixlevel'] = $this->readHeaderBSI(5);
			$thisfile_ac3_raw_bsi['roomtyp']  = $this->readHeaderBSI(2);

			$thisfile_ac3['mixing_level'] = (80 + $thisfile_ac3_raw_bsi['mixlevel']).'dB';
			$thisfile_ac3['room_type']    = self::roomTypeLookup($thisfile_ac3_raw_bsi['roomtyp']);
		}

		if ($thisfile_ac3_raw_bsi['acmod'] == 0x00) {
			// If acmod is 0, then two completely independent program channels (dual mono)
			// are encoded into the bit stream, and are referenced as Ch1, Ch2. In this case,
			// a number of additional items are present in BSI or audblk to fully describe Ch2.

			// This indicates how far the average dialogue level is below digital 100 percent. Valid values are 1-31.
			// The value of 0 is reserved. The values of 1 to 31 are interpreted as -1 dB to -31 dB with respect to digital 100 percent.
			$thisfile_ac3_raw_bsi['dialnorm2'] = $this->readHeaderBSI(5);
			$thisfile_ac3['dialogue_normalization2'] = '-'.$thisfile_ac3_raw_bsi['dialnorm2'].'dB';

			$thisfile_ac3_raw_bsi['compre_flag2'] = (bool) $this->readHeaderBSI(1);
			if ($thisfile_ac3_raw_bsi['compre_flag2']) {
				$thisfile_ac3_raw_bsi['compr2'] = $this->readHeaderBSI(8);
				$thisfile_ac3['heavy_compression2'] = self::heavyCompression($thisfile_ac3_raw_bsi['compr2']);
			}

			$thisfile_ac3_raw_bsi['langcode_flag2'] = (bool) $this->readHeaderBSI(1);
			if ($thisfile_ac3_raw_bsi['langcode_flag2']) {
				$thisfile_ac3_raw_bsi['langcod2'] = $this->readHeaderBSI(8);
			}

			$thisfile_ac3_raw_bsi['audprodie2'] = (bool) $this->readHeaderBSI(1);
			if ($thisfile_ac3_raw_bsi['audprodie2']) {
				$thisfile_ac3_raw_bsi['mixlevel2'] = $this->readHeaderBSI(5);
				$thisfile_ac3_raw_bsi['roomtyp2']  = $this->readHeaderBSI(2);

				$thisfile_ac3['mixing_level2'] = (80 + $thisfile_ac3_raw_bsi['mixlevel2']).'dB';
				$thisfile_ac3['room_type2']    = self::roomTypeLookup($thisfile_ac3_raw_bsi['roomtyp2']);
			}

		}

		$thisfile_ac3_raw_bsi['copyright'] = (bool) $this->readHeaderBSI(1);

		$thisfile_ac3_raw_bsi['original']  = (bool) $this->readHeaderBSI(1);

		$thisfile_ac3_raw_bsi['timecode1_flag'] = (bool) $this->readHeaderBSI(1);
		if ($thisfile_ac3_raw_bsi['timecode1_flag']) {
			$thisfile_ac3_raw_bsi['timecode1'] = $this->readHeaderBSI(14);
		}

		$thisfile_ac3_raw_bsi['timecode2_flag'] = (bool) $this->readHeaderBSI(1);
		if ($thisfile_ac3_raw_bsi['timecode2_flag']) {
			$thisfile_ac3_raw_bsi['timecode2'] = $this->readHeaderBSI(14);
		}

		$thisfile_ac3_raw_bsi['addbsi_flag'] = (bool) $this->readHeaderBSI(1);
		if ($thisfile_ac3_raw_bsi['addbsi_flag']) {
			$thisfile_ac3_raw_bsi['addbsi_length'] = $this->readHeaderBSI(6);

			$this->AC3header['bsi'] .= getid3_lib::BigEndian2Bin($this->fread($thisfile_ac3_raw_bsi['addbsi_length']));

			$thisfile_ac3_raw_bsi['addbsi_data'] = substr($this->AC3header['bsi'], $this->BSIoffset, $thisfile_ac3_raw_bsi['addbsi_length'] * 8);
			$this->BSIoffset += $thisfile_ac3_raw_bsi['addbsi_length'] * 8;
		}

		return true;
	}

	private function readHeaderBSI($length) {
		$data = substr($this->AC3header['bsi'], $this->BSIoffset, $length);
		$this->BSIoffset += $length;

		return bindec($data);
	}

	public static function sampleRateCodeLookup($fscod) {
		static $sampleRateCodeLookup = array(
			0 => 48000,
			1 => 44100,
			2 => 32000,
			3 => 'reserved' // If the reserved code is indicated, the decoder should not attempt to decode audio and should mute.
		);
		return (isset($sampleRateCodeLookup[$fscod]) ? $sampleRateCodeLookup[$fscod] : false);
	}

	public static function serviceTypeLookup($bsmod, $acmod) {
		static $serviceTypeLookup = array();
		if (empty($serviceTypeLookup)) {
			for ($i = 0; $i <= 7; $i++) {
				$serviceTypeLookup[0][$i] = 'main audio service: complete main (CM)';
				$serviceTypeLookup[1][$i] = 'main audio service: music and effects (ME)';
				$serviceTypeLookup[2][$i] = 'associated service: visually impaired (VI)';
				$serviceTypeLookup[3][$i] = 'associated service: hearing impaired (HI)';
				$serviceTypeLookup[4][$i] = 'associated service: dialogue (D)';
				$serviceTypeLookup[5][$i] = 'associated service: commentary (C)';
				$serviceTypeLookup[6][$i] = 'associated service: emergency (E)';
			}

			$serviceTypeLookup[7][1]      = 'associated service: voice over (VO)';
			for ($i = 2; $i <= 7; $i++) {
				$serviceTypeLookup[7][$i] = 'main audio service: karaoke';
			}
		}
		return (isset($serviceTypeLookup[$bsmod][$acmod]) ? $serviceTypeLookup[$bsmod][$acmod] : false);
	}

	public static function audioCodingModeLookup($acmod) {
		// array(channel configuration, # channels (not incl LFE), channel order)
		static $audioCodingModeLookup = array (
			0 => array('channel_config'=>'1+1', 'num_channels'=>2, 'channel_order'=>'Ch1,Ch2'),
			1 => array('channel_config'=>'1/0', 'num_channels'=>1, 'channel_order'=>'C'),
			2 => array('channel_config'=>'2/0', 'num_channels'=>2, 'channel_order'=>'L,R'),
			3 => array('channel_config'=>'3/0', 'num_channels'=>3, 'channel_order'=>'L,C,R'),
			4 => array('channel_config'=>'2/1', 'num_channels'=>3, 'channel_order'=>'L,R,S'),
			5 => array('channel_config'=>'3/1', 'num_channels'=>4, 'channel_order'=>'L,C,R,S'),
			6 => array('channel_config'=>'2/2', 'num_channels'=>4, 'channel_order'=>'L,R,SL,SR'),
			7 => array('channel_config'=>'3/2', 'num_channels'=>5, 'channel_order'=>'L,C,R,SL,SR'),
		);
		return (isset($audioCodingModeLookup[$acmod]) ? $audioCodingModeLookup[$acmod] : false);
	}

	public static function centerMixLevelLookup($cmixlev) {
		static $centerMixLevelLookup;
		if (empty($centerMixLevelLookup)) {
			$centerMixLevelLookup = array(
				0 => pow(2, -3.0 / 6), // 0.707 (-3.0 dB)
				1 => pow(2, -4.5 / 6), // 0.595 (-4.5 dB)
				2 => pow(2, -6.0 / 6), // 0.500 (-6.0 dB)
				3 => 'reserved'
			);
		}
		return (isset($centerMixLevelLookup[$cmixlev]) ? $centerMixLevelLookup[$cmixlev] : false);
	}

	public static function surroundMixLevelLookup($surmixlev) {
		static $surroundMixLevelLookup;
		if (empty($surroundMixLevelLookup)) {
			$surroundMixLevelLookup = array(
				0 => pow(2, -3.0 / 6),
				1 => pow(2, -6.0 / 6),
				2 => 0,
				3 => 'reserved'
			);
		}
		return (isset($surroundMixLevelLookup[$surmixlev]) ? $surroundMixLevelLookup[$surmixlev] : false);
	}

	public static functi