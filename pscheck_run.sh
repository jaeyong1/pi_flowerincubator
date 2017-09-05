#!/bin/bash 
http="`ps -ef | grep flowerincubator.py | grep -v grep | wc -l`"
if [ "$http" -eq "0" ] ; then
	echo "program not in running, start"
	python /home/pi/garden/pi_flowerincubator/flowerincubator.py &
fi

