/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////

*****************************************************************
*****************************************************************

   getID3() is released under multiple licenses. You may choose
   from the following licenses, and use getID3 according to the
   terms of the license most suitable to your project.

GNU GPL: https://gnu.org/licenses/gpl.html                   (v3)
         https://gnu.org/licenses/old-licenses/gpl-2.0.html  (v2)
         https://gnu.org/licenses/old-licenses/gpl-1.0.html  (v1)

GNU LGPL: https://gnu.org/licenses/lgpl.html                 (v3)

Mozilla MPL: http://www.mozilla.org/MPL/2.0/                 (v2)

getID3 Commercial License: http://getid3.org/#gCL (payment required)

*****************************************************************
*****************************************************************
Copies of each of the above licenses are included in the 'licenses'
directory of the getID3 distribution.


       +---------------------------------------------+
       | If you want to donate, there is a link on   |
       | http://www.getid3.org for PayPal donations. |
       +---------------------------------------------+


Quick Start
===========================================================================

Q: How can I check that getID3() works on my server/files?
A: Unzip getID3() to a directory, then access /demos/demo.browse.php



Support
===========================================================================

Q: I have a question, or I found a bug. What do I do?
A: The preferred method of support requests and/or bug reports is the
   forum at http://support.getid3.org/



Sourceforge Notification
===========================================================================

It's highly recommended that you sign up for notification from
Sourceforge for when new versions are released. Please visit:
http://sourceforge.net/project/showfiles.php?group_id=55859
and click the little "monitor package" icon/link.  If you're
previously signed up for the mailing list, be aware that it has
been discontinued, only the automated Sourceforge notification
will be used from now on.



What does getID3() do?
===========================================================================

Reads & parses (to varying degrees):
# tags:
  * APE (v1 and v2)
  * ID3v1 (& ID3v1.1)
  * ID3v2 (v2.4, v2.3, v2.2)
  * Lyrics3 (v1 & v2)

# audio-lossy:
  * MP3/MP2/MP1
  * MPC / Musepack
  * Ogg (Vorbis, OggFLAC, Speex)
  * AAC / MP4
  * AC3
  * DTS
  * RealAudio
  * Speex
  * DSS
  * VQF

# audio-lossless:
  * AIFF
  * AU
  * Bonk
  * CD-audio (*.cda)
  * FLAC
  * LA (Lossless Audio)
  * LiteWave
  * LPAC
  * MIDI
  * Monkey's Audio
  * OptimFROG
  * RKAU
  * Shorten
  * TTA
  * VOC
  * WAV (RIFF)
  * WavPack

# audio-video:
  * ASF: ASF, Windows Media Audio (WMA), Windows Media Video (WMV)
  * AVI (RIFF)
  * Flash
  * Matroska (MKV)
  * MPEG-1 / MPEG-2
  * NSV (Nullsoft Streaming Video)
  * Quicktime (including MP4)
  * RealVideo

# still image:
  * BMP
  * GIF
  * JPEG
  * PNG
  * TIFF
  * SWF (Flash)
  * PhotoCD

# data:
  * ISO-9660 CD-ROM image (directory structure)
  * SZIP (limited support)
  * ZIP (directory structure)
  * TAR
  * CUE


Writes:
  * ID3v1 (& ID3v1.1)
  * ID3v2 (v2.3 & v2.4)
  * VorbisComment on OggVorbis
  * VorbisComment on FLAC (not OggFLAC)
  * APE v2
  * Lyrics3 (delete only)



Requirements
===========================================================================

* PHP 4.2.0 up to 5.2.x for getID3() 1.7.x (and earlier)
* PHP 5.0.5 (or higher) for getID3() 1.8.x (and up)
* PHP 5.0.5 (or higher) for getID3() 2.0.x (and up)
* at least 4MB memory for PHP. 8MB or more is highly recommended.
  12MB is required with all modules loaded.



Usage
===========================================================================

See /demos/demo.basic.php for a very basic use of getID3() with no
fancy output, just scanning one file.

See structure.txt for the returned data structure.

*>  For an example of a complete directory-browsing,       <*
*>  file-scanning implementation of getID3(), please run   <*
*>  /demos/demo.browse.php                                 <*

See /demos/demo.mysql.php for a sample recursive scanning code that
scans every file in a given directory, and all sub-directories, stores
the results in a database and allows various analysis / maintenance
operations

To analyze remote files over HTTP or FTP you need to copy the file
locally first before running getID3(). Your code would look something
like this:

// Copy remote file locally to scan with getID3()
$remotefilename = 'http://www.example.com/filename.mp3';
if ($fp_remote = fopen($remotefilename, 'rb')) {
    $localtempfilename = tempnam('/tmp', 'getID3');
    if ($fp_local = fopen($localtempfilename, 'wb')) {
        while ($buffer = fread($fp_remote, 8192)) {
            fwrite($fp_local, $buffer);
        }
        fclose($fp_local);

		// Initialize getID3 engine
		$getID3 = new getID3;

		$ThisFileInfo = $getID3->analyze($filename);

        // Delete temporary file
        unlink($localtempfilename);
    }
    fclose($fp_remote);
}


See /demos/demo.write.php for how to write tags.



What does the returned data structure look like?
===========================================================================

See structure.txt

It is recommended that you look at the output of
/demos/demo.browse.php scanning the file(s) you're interested in to
confirm what data is actually returned for any particular filetype in
general, and your files in particular, as the actual data returned
may vary considerably depending on what information is available in
the file itself.



Notes
===========================================================================

getID3() 1.x:
If the format parser encounters a critical problem, it will return
something in $fileinfo['error'], describing the encountered error. If
a less critical error or notice is generated it will appear in
$fileinfo['warning']. Both keys may contain more than one warning or
error. If something is returned in ['error'] then the file was not
correctly parsed and returned data may or may not be correct and/or
complete. If something is returned in ['warning'] (and not ['error'])
then the data that is returned is OK - usually getID3() is reporting
errors in the file that have been worked around due to known bugs in
other programs. Some warnings may indicate that the data that is
returned is OK but that some data could not be extracted due to
errors in the file.

getID3() 2.x:
See above except errors are thrown (so you will only get one error).



Disclaimer
===========================================================================

getID3() has been tested on many systems, on many types of files,
under many operating systems, and is generally believe to be stable
and safe. That being said, there is still the chance there is an
undiscovered and/or unfixed bug that may potentially corrupt your
file, especially within the writing functions. By using getID3() you
agree that it's not my fault if any of your files are corrupted.
In fact, I'm not liable for anything :)



License
===========================================================================

GNU General Public License - see license.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to:
Free Software Foundation, Inc.
59 Temple Place - Suite 330
Boston, MA  02111-1307, USA.

FAQ:
Q: Can I use getID3() in my program? Do I need a commercial license?
A: You're generally free to use getID3 however you see fit. The only
   case in which you would require a commercial license is if you're
   selling your closed-source program that integrates getID3. If you
   sell your program including a copy of getID3, that's fine as long
   as you include a copy of the sourcecode when you sell it.  Or you
   can distribute your code without getID3 and say "download it from
   getid3.sourceforge.net"



Why is it called "getID3()" if it does so much more than just that?
===========================================================================

v0.1 did in fact just do that. I don't have a copy of code that old, but I
could essentially write it today with a one-line function:
  function getID3($filename) { return unpack('a3TAG/a30title/a30artist/a30album/a4year/a28comment/c1track/c1genreid', substr(file_get_contents($filename), -128)); }


Future Plans
===========================================================================
http://www.getid3.org/phpBB3/viewforum.php?f=7

* Better support for MP4 container format
* Scan for appended ID3v2 tag at end of file per ID3v2.4 specs (Section 5.0)
* Support for JPEG-2000 (http://www.morgan-multimedia.com/jpeg2000_overview.htm)
* Support for MOD (mod/stm/s3m/it/xm/mtm/ult/669)
* Support for ACE (thanks Vince)
* Support for Ogg other than Vorbis, Speex and OggFlac (ie. Ogg+Xvid)
* Ability to create Xing/LAME VBR header for VBR MP3s that are missing VBR header
* Ability to "clean" ID3v2 padding (replace invalid padding with valid padding)
* Warn if MP3s change version mid-stream (in full-scan mode)
* check for corrupt/broken mid-file MP3 streams in histogram scan
* Support for lossless-compression formats
  (http://www.firstpr.com.au/audiocomp/lossless/#Links)
  (http://compression.ca/act-sound.html)
  (http://web.inter.nl.net/users/hvdh/lossless/lossless.htm)
* Support for RIFF-INFO chunks
  * http://lotto.st-andrews.ac.uk/~njh/tag_interchange.html
    (thanks Nick Humfrey <njh@surgeradio*co*uk>)
  * http://abcavi.narod.ru/sof/abcavi/infotags.htm
    (thanks Kibi)
* Better support for Bink video
* http://www.hr/josip/DSP/AudioFile2.html
* http://www.pcisys.net/~melanson/codecs/
* Detect mp3PRO
* Support for PSD
* Support for JPC
* Support for JP2
* Support for JPX
* Support for JB2
* Support for IFF
* Support for ICO
* Support for ANI
* Support for EXE (comments, author, etc) (thanks p*quaedackers@planet*nl)
* Support for DVD-IFO (region, subtitles, aspect ratio, etc)
  (thanks p*quaedackers@planet*nl)
* More complete support for SWF - parsing encapsulated MP3 and/or JPEG content
    (thanks n8n8@yahoo*com)
* Support for a2b
* Optional scan-through-frames for AVI verification
  (thanks rockcohen@massive-interactive*nl)
* Support for TTF (thanks info@butterflyx*com)
* Support for DSS (http://www.getid3.org/phpBB3/viewtopic.php?t=171)
* Support for SMAF (http://smaf-yamaha.com/what/demo.html)
  http://www.getid3.org/phpBB3/viewtopic.php?t=182
* Support for AMR (http://www.getid3.org/phpBB3/viewtopic.php?t=195)
* Support for 3gpp (http://www.getid3.org/phpBB3/viewtopic.php?t=195)
* Support for ID4 (http://www.wackysoft.cjb.net grizlyY2K@hotmail*com)
* Parse XML data returned in Ogg comments
* Parse XML data from Quicktime SMIL metafiles (klausrath@mac*com)
* ID3v2 genre string creator function
* More complete parsing of JPG
* Support for all old-style ASF packets
* ASF/WMA/WMV tag writing
* Parse declared T??? ID3v2 text information frames, where appropriate
    (thanks Christian Fritz for the idea)
* Recognize encoder:
  http://www.guerillasoft.com/EncSpot2/index.html
  http://ff123.net/identify.html
  http://www.hydrogenaudio.org/?act=ST&f=16&t=9414
  http://www.hydrogenaudio.org/?showtopic=11785
* Support for other OS/2 bitmap structures: Bitmap Array('BA'),
  Color Icon('CI'), Color Pointer('CP'), Icon('IC'), Pointer ('PT')
  http://netghost.narod.ru/gff/graphics/summary/os2bmp.htm
* Support for WavPack RAW mode
* ASF/WMA/WMV data packet parsing
* ID3v2FrameFlagsLookupTagAlter()
* ID3v2FrameFlagsLookupFileAlter()
* obey ID3v2 tag alter/preserve/discard rules
* http://www.geocities.com/SiliconValley/Sector/9654/Softdoc/Illyrium/Aolyr.htm
* proper checking for LINK/LNK frame validity in ID3v2 writing
* proper checking for ASPI-TLEN frame validity in ID3v2 writing
* proper checking for COMR frame validity in ID3v2 writing
* http://www.geocities.co.jp/SiliconValley-Oakland/3664/index.html
* decode GEOB ID3v2 structure as encoded by RealJukebox,
  decode NCON ID3v2 structure as encoded by MusicMatch
  (probably won't happen - the formats are proprietary)



Known Bugs/Issues in getID3() that may be fixed eventually
===========================================================================
http://www.getid3.org/phpBB3/viewtopic.php?t=25

* Cannot determine bitrate for MPEG video with VBR video data
  (need documentation)
* Interlace/progressive cannot be determined for MPEG video
  (need documentation)
* MIDI playtime is sometimes inaccurate
* AAC-RAW mode files cannot be identified
* WavPack-RAW mode files cannot be identified
* mp4 files report lots of "Unknown QuickTime atom type"
   (need documentation)
* Encrypted ASF/WMA/WMV files warn about "unhandled GUID
  ASF_Content_Encryption_Object"
* Bitrate split between audio and video cannot be calculated for
  NSV, only the total bitrate. (need documentation)
* All Ogg formats (Vorbis, OggFLAC, Speex) are affected by the
  problem of large VorbisComments spanning multiple Ogg pages, but
  but only OggVorbis files can be processed with vorbiscomment.
* The version of "head" supplied with Mac OS 10.2.8 (maybe other
  versions too) does only understands a single option (-n) and
  therefor