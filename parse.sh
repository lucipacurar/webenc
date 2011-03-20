#!/bin/bash
if [ "$1" = "video" ]; then
	while sleep 1; do
		logfile=${2%.*}.txt;
		progress=$(cat $logfile | egrep -o "\[[0-9.%]*\]" | tail -n 1 | cut -d"[" -f2 | cut -d"]" -f1 | cut -d"%" -f1);
		eta=$(cat $logfile | egrep -o "eta [0-9:]*" | tail -n 1 | cut -d" " -f2);
		end=$(cat $logfile | egrep -o "encoded [0-9/]*" | cut -d" " -f1);
		./connection.php $1 $2 $progress $eta;
		if [ "$end" = "encoded" ]; then
			echo "ended";
			break;
		fi
	done
fi
if [ "$1" = "audio" ]; then
	sleep 1;
	logfile=${2%.*}_audio.txt;
	hours=$(cat $logfile | egrep -o "Duration: [0-9:]*" | cut -d":" -f2);
	minutes=$(cat $logfile | egrep -o "Duration: [0-9:]*" | cut -d":" -f3);
	seconds=$(cat $logfile | egrep -o "Duration: [0-9:]*" | cut -d":" -f4);
	length=$(($hours*3600+$minutes*60+$seconds));
	while sleep 1; do
		progress=$(cat $logfile | egrep -o "time=[0-9.]*" | tail -n 1 | cut -d"=" -f2 | cut -d"." -f1);
		progresspercent=$(($progress*100 / $length));
		echo $progresspercent;
		./connection.php $1 $2 $progresspercent;
		if [ "$progresspercent" = "100" ]; then
			sleep 5;
			break;
		fi
	done
fi
if [ "$1" = "mux" ]; then
	logfile=${2%.*}_mux.txt;
	while sleep 1; do
		string=$(cat $logfile | sed 's/|=*\ *|\ //');
		echo $string;
	done
fi