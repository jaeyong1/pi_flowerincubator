#!/usr/bin/env python
# Get humidity and temperature from DHT22 sensor
# This file uses the precompiled C library.
# The data line of the DHT22 sensor is connected to the raspberry pi GPIO #22.
# ----------------------
# Raspberry PI Model B+
# PIN1-VCC3.3 
# PIN9-GND
# PIN15-GPIO#22
#
# @link : https://github.com/jaeyong1/pi_flowerincubator/wiki/Get-temperature-and-humidity/
# @author jaeyongyong park (yongslab.com)

import subprocess

def get_humidity_temperature(returnlst):	
	curpath = os.getcwd()
	batcmd= "." + curpath + "/dht.lib"
	resultbat = subprocess.check_output(batcmd, shell=True)
	#print("----\n" + resultbat + "------")
	lstbat = resultbat.split('\n')
	for i in range (0, len(lstbat)):
		if "Failed" in lstbat[i]:
			return False
		if "OK." in lstbat[i]:
			#print("Found : " + lstbat[i])
			lstchar = lstbat[i].split(' ')
			returnlst[0] = lstchar[3] # humidity
			returnlst[1] = lstchar[7] # temperature
			print("[dht] humidity = " + returnlst[0] + " %")
			print("[dht] temperature = " + returnlst[1] + " *C")
			return True
  
def main():
	lst=["",""]
	if (get_humidity_temperature(lst) == True):		
		print("[main] humidity = " + lst[0])
		print("[main] temperature = " + lst[1])

if __name__ == '__main__':
	main()
	

		