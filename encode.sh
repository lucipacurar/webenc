#!/bin/bash
source=$1;
bitrate=$2;
profile=$3;
preset=$4;
if [[ "$5" == "none" ]]; then
	echo no tunnings;
else
	tune="--tune "$5;
fi
if [[ "$6" == "" ]] && [[ "$7" == "" ]]; then
	echo no resize;
else
	resize="--video-filter resize:"$6","$7;
fi
audiochannels=$(mediainfo $1 | grep "channels" | cut -d":" -f2 | cut -d" " -f2);
samplerate=$(mediainfo $1 | grep "KHz" | cut -d":" -f2 | cut -d" " -f2);
fps=$(mediainfo $1 | grep "fps" | cut -d":" -f2 | cut -d" " -f2);
echo $fps;
rm ${source%.*}_mux.txt
rm ${source%.*}_audio.txt
rm ${source%.*}.txt
rm ${source%.*}.h264
rm ${source%.*}_audio.aac
rm ${source%.*}.mp4
x264 --bitrate $bitrate --preset $preset --profile $profile --fps $fps $tune $resize -o ${source%.*}.h264 $source 2>${source%.*}.txt | ./parse.sh video $source
ffmpeg -i $source -vn -acodec libfaac -ac 2 -ar 44100 -ab 128k ${source%.*}_audio.aac 2>${source%.*}_audio.txt | ./parse.sh audio $source
./connection.php mux $source Started
MP4Box -add ${source%.*}.h264#video:fps=$fps -add ${source%.*}_audio.aac#audio -inter 500 ${source%.*}.mp4 >${source%.*}_mux.txt
./connection.php mux $source Ended