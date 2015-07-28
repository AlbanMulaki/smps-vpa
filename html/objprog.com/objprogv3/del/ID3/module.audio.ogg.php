<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio.ogg.php                                        //
// module for analyzing Ogg Vorbis, OggFLAC and Speex files    //
// dependencies: module.audio.flac.php                         //
//                                                            ///
/////////////////////////////////////////////////////////////////

getid3_lib::IncludeDependency(GETID3_INCLUDEPATH.'module.audio.flac.php', __FILE__, true);

class getid3_ogg extends getid3_handler
{
	// http://xiph.org/vorbis/doc/Vorbis_I_spec.html
	public function Analyze() {
		$info = &$this->getid3->info;

		$info['fileformat'] = 'ogg';

		// Warn about illegal tags - only vorbiscomments are allowed
		if (isset($info['id3v2'])) {
			$info['warning'][] = 'Illegal ID3v2 tag present.';
		}
		if (isset($info['id3v1'])) {
			$info['warning'][] = 'Illegal ID3v1 tag present.';
		}
		if (isset($info['ape'])) {
			$info['warning'][] = 'Illegal APE tag present.';
		}


		// Page 1 - Stream Header

		$this->fseek($info['avdataoffset']);

		$oggpageinfo = $this->ParseOggPageHeader();
		$info['ogg']['pageheader'][$oggpageinfo['page_seqno']] = $oggpageinfo;

		if ($this->ftell() >= $this->getid3->fread_buffer_size()) {
			$info['error'][] = 'Could not find start of Ogg page in the first '.$this->getid3->fread_buffer_size().' bytes (this might not be an Ogg-Vorbis file?)';
			unset($info['fileformat']);
			unset($info['ogg']);
			return false;
		}

		$filedata = $this->fread($oggpageinfo['page_length']);
		$filedataoffset = 0;

		if (substr($filedata, 0, 4) == 'fLaC') {

			$info['audio']['dataformat']   = 'flac';
			$info['audio']['bitrate_mode'] = 'vbr';
			$info['audio']['lossless']     = true;

		} elseif (substr($filedata, 1, 6) == 'vorbis') {

			$this->ParseVorbisPageHeader($filedata, $filedataoffset, $oggpageinfo);

		} elseif (substr($filedata, 0, 8) == 'Speex   ') {

			// http://www.speex.org/manual/node10.html

			$info['audio']['dataformat']   = 'speex';
			$info['mime_type']             = 'audio/speex';
			$info['audio']['bitrate_mode'] = 'abr';
			$info['audio']['lossless']     = false;

			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['speex_string']           =                              substr($filedata, $filedataoffset, 8); // hard-coded to 'Speex   '
			$filedataoffset += 8;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['speex_version']          =                              substr($filedata, $filedataoffset, 20);
			$filedataoffset += 20;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['speex_version_id']       = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['header_size']            = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['rate']                   = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['mode']                   = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['mode_bitstream_version'] = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['nb_channels']            = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['bitrate']                = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['framesize']              = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['vbr']                    = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['frames_per_packet']      = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['extra_headers']          = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['reserved1']              = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;
			$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['reserved2']              = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 4));
			$filedataoffset += 4;

			$info['speex']['speex_version'] = trim($info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['speex_version']);
			$info['speex']['sample_rate']   = $info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['rate'];
			$info['speex']['channels']      = $info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['nb_channels'];
			$info['speex']['vbr']           = (bool) $info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['vbr'];
			$info['speex']['band_type']     = $this->SpeexBandModeLookup($info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['mode']);

			$info['audio']['sample_rate']   = $info['speex']['sample_rate'];
			$info['audio']['channels']      = $info['speex']['channels'];
			if ($info['speex']['vbr']) {
				$info['audio']['bitrate_mode'] = 'vbr';
			}


		} elseif (substr($filedata, 0, 8) == "fishead\x00") {

			// Ogg Skeleton version 3.0 Format Specification
			// http://xiph.org/ogg/doc/skeleton.html
			$filedataoffset += 8;
			$info['ogg']['skeleton']['fishead']['raw']['version_major']                = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  2));
			$filedataoffset += 2;
			$info['ogg']['skeleton']['fishead']['raw']['version_minor']                = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  2));
			$filedataoffset += 2;
			$info['ogg']['skeleton']['fishead']['raw']['presentationtime_numerator']   = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  8));
			$filedataoffset += 8;
			$info['ogg']['skeleton']['fishead']['raw']['presentationtime_denominator'] = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  8));
			$filedataoffset += 8;
			$info['ogg']['skeleton']['fishead']['raw']['basetime_numerator']           = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  8));
			$filedataoffset += 8;
			$info['ogg']['skeleton']['fishead']['raw']['basetime_denominator']         = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  8));
			$filedataoffset += 8;
			$info['ogg']['skeleton']['fishead']['raw']['utc']                          = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset, 20));
			$filedataoffset += 20;

			$info['ogg']['skeleton']['fishead']['version']          = $info['ogg']['skeleton']['fishead']['raw']['version_major'].'.'.$info['ogg']['skeleton']['fishead']['raw']['version_minor'];
			$info['ogg']['skeleton']['fishead']['presentationtime'] = $info['ogg']['skeleton']['fishead']['raw']['presentationtime_numerator'] / $info['ogg']['skeleton']['fishead']['raw']['presentationtime_denominator'];
			$info['ogg']['skeleton']['fishead']['basetime']         = $info['ogg']['skeleton']['fishead']['raw']['basetime_numerator']         / $info['ogg']['skeleton']['fishead']['raw']['basetime_denominator'];
			$info['ogg']['skeleton']['fishead']['utc']              = $info['ogg']['skeleton']['fishead']['raw']['utc'];


			$counter = 0;
			do {
				$oggpageinfo = $this->ParseOggPageHeader();
				$info['ogg']['pageheader'][$oggpageinfo['page_seqno'].'.'.$counter++] = $oggpageinfo;
				$filedata = $this->fread($oggpageinfo['page_length']);
				$this->fseek($oggpageinfo['page_end_offset']);

				if (substr($filedata, 0, 8) == "fisbone\x00") {

					$filedataoffset = 8;
					$info['ogg']['skeleton']['fisbone']['raw']['message_header_offset']   = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  4));
					$filedataoffset += 4;
					$info['ogg']['skeleton']['fisbone']['raw']['serial_number']           = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  4));
					$filedataoffset += 4;
					$info['ogg']['skeleton']['fisbone']['raw']['number_header_packets']   = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  4));
					$filedataoffset += 4;
					$info['ogg']['skeleton']['fisbone']['raw']['granulerate_numerator']   = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  8));
					$filedataoffset += 8;
					$info['ogg']['skeleton']['fisbone']['raw']['granulerate_denominator'] = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  8));
					$filedataoffset += 8;
					$info['ogg']['skeleton']['fisbone']['raw']['basegranule']             = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  8));
					$filedataoffset += 8;
					$info['ogg']['skeleton']['fisbone']['raw']['preroll']                 = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  4));
					$filedataoffset += 4;
					$info['ogg']['skeleton']['fisbone']['raw']['granuleshift']            = getid3_lib::LittleEndian2Int(substr($filedata, $filedataoffset,  1));
					$filedataoffset += 1;
					$info['ogg']['skeleton']['fisbone']['raw']['padding']                 =                              substr($filedata, $filedataoffset,  3);
					$filedataoffset += 3;

				} elseif (substr($filedata, 1, 6) == 'theora') {

					$info['video']['dataformat'] = 'theora';
					$info['error'][] = 'Ogg Theora not correctly handled in this version of getID3 ['.$this->getid3->version().']';
					//break;

				} elseif (substr($filedata, 1, 6) == 'vorbis') {

					$this->ParseVorbisPageHeader($filedata, $filedataoffset, $oggpageinfo);

				} else {
					$info['error'][] = 'unexpected';
					//break;
				}
			//} while ($oggpageinfo['page_seqno'] == 0);
			} while (($oggpageinfo['page_seqno'] == 0) && (substr($filedata, 0, 8) != "fisbone\x00"));

			$this->fseek($oggpageinfo['page_start_offset']);

			$info['error'][] = 'Ogg Skeleton not correctly handled in this version of getID3 ['.$this->getid3->version().']';
			//return false;

		} else {

			$info['error'][] = 'Expecting either "Speex   " or "vorbis" identifier strings, found "'.substr($filedata, 0, 8).'"';
			unset($info['ogg']);
			unset($info['mime_type']);
			return false;

		}

		// Page 2 - Comment Header
		$oggpageinfo = $this->ParseOggPageHeader();
		$info['ogg']['pageheader'][$oggpageinfo['page_seqno']] = $oggpageinfo;

		switch ($info['audio']['dataformat']) {
			case 'vorbis':
				$filedata = $this->fread($info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['page_length']);
				$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['packet_type'] = getid3_lib::LittleEndian2Int(substr($filedata, 0, 1));
				$info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['stream_type'] =                              substr($filedata, 1, 6); // hard-coded to 'vorbis'

				$this->ParseVorbisComments();
				break;

			case 'flac':
				$flac = new getid3_flac($this->getid3);
				if (!$flac->parseMETAdata()) {
					$info['error'][] = 'Failed to parse FLAC headers';
					return false;
				}
				unset($flac);
				break;

			case 'speex':
				$this->fseek($info['ogg']['pageheader'][$oggpageinfo['page_seqno']]['page_length'], SEEK_CUR);
				$this->ParseVorbisComments();
				break;
		}


		// Last Page - Number of Samples
		if (!getid3_lib::intValueSupported($info['avdataend'])) {

			$info['warning'][] = 'Unable to parse Ogg end chunk file (PHP does not support file operations beyond '.round(PHP_INT_MAX / 1073741824).'GB)';

		} else {

			$this->fseek(max($info['avdataend'] - $this->getid3->fread_buffer_size(), 0));
			$LastChunkOfOgg = strrev($this->fread($this->getid3->fread_buffer_size()));
			if ($LastOggSpostion = strpos($LastChunkOfOgg, 'SggO')) {
				$this->fseek($info['avdataend'] - ($LastOggSpostion + strlen('SggO')));
				$info['avdataend'] = $this->ftell();
				$info['ogg']['pageheader']['eos'] = $this->ParseOggPageHeader();
				$info['ogg']['samples']   = $info['ogg']['pageheader']['eos']['pcm_abs_position'];
				if ($info['ogg']['samples'] == 0) {
					$info['error'][] = 'Corrupt Ogg file: eos.number of samples == zero';
					return false;
				}
				if (!empty($info['audio']['sample_rate'])) {
					$info['ogg']['bitrate_average'] = (($info['avdataend'] - $info['avdataoffset']) * 8) / ($info['ogg']['samples'] / $info['audio']['sample_rate']);
				}
			}

		}

		if (!empty($info['ogg']['bitrate_average'])) {
			$info['audio']['bitrate'] = $info['ogg']['bitrate_average'];
		} elseif (!empty($info['ogg']['bitrate_nominal'])) {
			$info['audio']['bitrate'] = $info['ogg']['bitrate_nominal'];
		} elseif (!empty($info['ogg']['bitrate_min']) && !empty($info['ogg']['bitrate_max'])) {
			$info['audio']['bitrate'] = ($info['ogg']['bitrate_min'] + $info['ogg']['bitrate_max']) / 2;
		}
		if (isset($info['audio']['bitrate']) && !isset($info['playtime_seconds'])) {
			if ($info['audio']['bitrate'] == 0) {
				$info['error'][] = 'Corrupt Ogg file: bitrate_audio == zero';
				return false;
			}
			$info['playtime_seconds'] = (float) ((($info['avdataend'] - $info['avdataoffset']) * 8) / $info['audio']['bitrate']);
		}

		if (isset($info['ogg']['vendor'])) {
			$info['audio']['encoder'] = preg_replace('/^Encoded with /', '', $info['ogg']['vendor']);

			// Vorbis only
			if ($info['audio']['da