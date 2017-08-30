#!/usr/bin/env python
import threading
import time
import feedparser
import urllib2 
from c_incubator import *

def setserverstate(incubator):
	# http://jaeyong1.cafe24.com/garden/set_garden_now.php?lamp=1&fan=0&humidity=30&temperature=40
	print("update garden now")
	urllib2.urlopen("http://jaeyong1.cafe24.com/garden/set_garden_now.php?lamp=" + str(incubator.lamp) + "&fan=" + str(incubator.fan)+ "&humidity=" + str(incubator.humidity) + "&temperature=" + str(incubator.temperature)).read() #python 2
	######################## PYTHON 3 ############################################
	#print ("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid)
	#	import urllib.request #python 3
	#	urllib.request.urlopen("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid).read()
	
def getserverstate():	
	#get command from db by xml
	d = feedparser.parse('http://jaeyong1.cafe24.com/garden/get_gardennow_xml.php')
	hasdata = d.feed.hasdata
	#print("hasdata:" + hasdata)
	
	#parse xml
	if int(hasdata) != 0:
		#print (d.feed.tm)
		#print (d.feed.lamp)
		#print (d.feed.fan)
		#print (d.feed.humidity)
		#print (d.feed.temperature)				
		incu = Incubator(d.feed.lamp, d.feed.fan, d.feed.humidity, d.feed.temperature)	
		return incu
	else:
		incu = Incubator(0, 0, 0, 0)
		incu.settingfailed()
		return incu
		

def main():
	print("get")
	r = getserverstate()
	print(r.lamp)
	print(r.fan)
	print(r.humidity)
	print(r.temperature)
	print("ser")
	setserverstate(r)

if __name__ == '__main__':
	main()
	
		