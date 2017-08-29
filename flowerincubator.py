#!/usr/bin/env python
import threading
import time
import feedparser
import RPi.GPIO as GPIO
import urllib2 
import datetime, time
from datetime import timedelta, datetime
from picftp import takepicture_ftpuplod
from tendo import singleton
me = singleton.SingleInstance() #singleton process

LONGSLEEPDURATION = 20 #30 sec, uses when there is no new command
SHORTSLEEPDURATION = 2 #2 sec, uses after command processing
PICTUREUPLOADDURATION = 300 #sec, take picture and upload to ftp server

def processcommand(command):
	
	if command.strip().upper() == "FAN OFF":
		FanOff()
	elif command.strip().upper() == "FAN ON":
		FanOn()
	elif command.strip().upper() == "LAMP ON":
		LightOn()
	elif command.strip().upper() == "LAMP OFF":
		LightOff()
	else:
	  print("cannot process command")
	
	
	
def getcommand():	
	#current date time ( 2017-01-01 13:23:45 )
	print("---------------------")
	now = time.localtime()	
	s = "%04d-%02d-%02d %02d:%02d:%02d" % (now.tm_year, now.tm_mon, now.tm_mday, now.tm_hour, now.tm_min, now.tm_sec)
	print s
	#get command from db by xml
	d = feedparser.parse('http://jaeyong1.cafe24.com/garden/get_remote_xml.php')
	hasdata = d.feed.hasdata
	print("hasdata:" + hasdata)
	
	#parse xml
	if int(hasdata) != 0:
		print (d.feed.rid)
		print (d.feed.timestamp)
		print (d.feed.command)
		print (d.feed.state)
		
		processcommand(d.feed.command)
		#set ok to db
		rid = d.feed.rid
		urllib2.urlopen("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid).read() #python 2
		######################### PYTHON 3 ############################################
		#print ("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid)
		#	import urllib.request #python 3
		#	urllib.request.urlopen("http://jaeyong1.cafe24.com/garden/set_remote_ok.php?rid="+rid).read()
		return True
	else:
		return False
		
 
def GPIOInit():
	GPIO.setmode(GPIO.BCM)
	GPIO.setup(14, GPIO.OUT)
	GPIO.setup(15, GPIO.OUT)	
	
def LightOn():
	print("> LIGHT ON")
	GPIO.output(15, True)

def LightOff():
	print("> LIGHT OFF")
	GPIO.output(15, False)

def FanOn():
	print("> FAN ON")
	GPIO.output(14, True)
	
def FanOff():
	print("> FAN OFF")
	GPIO.output(14, False)

def _internal_GPIOcontrolTest():
	GPIO.setmode(GPIO.BCM)
	GPIO.setup(15, GPIO.OUT)
	GPIO.output(15, False)
	#GPIO.output(14, True)
	GPIO.output(15, True)	
	GPIO.output(15, False)
	GPIO.cleanup()

def pisleep(sec):
	time.sleep(sec) #1sec

def picftp(lastuploaded):
	now = datetime.now()
	td = timedelta(seconds = PICTUREUPLOADDURATION)
	nextupload = lastuploaded + td
	
	if(now >= nextupload):
		print("upload image now")
		takepicture_ftpuplod()
		return now
	else:
		print("do not upload new image")
		return lastuploaded
	
	
	
def whileloopthread():
	td_init = timedelta(seconds = PICTUREUPLOADDURATION)
	lastuploaded = datetime.now() - td_init
	while True:
		lastuploaded = picftp(lastuploaded)
		while getcommand():
			print("has command, check again after short sleep")
			time.sleep(SHORTSLEEPDURATION)
		print("no command, long sleep")
		time.sleep(LONGSLEEPDURATION)

def main():
	print("****************************************************")
	print("PI FLOWER INCUBATOR")
	print("")	
	print("https://github.com/jaeyong1/pi_flowerincubator/wiki")	
	print("****************************************************")
	print("  1) get command from web site")
	print("  2) wait 1 min")
	print("  3) get command again")
	print("")
	now = time.localtime()
	s = "%04d-%02d-%02d %02d:%02d:%02d" % (now.tm_year, now.tm_mon, now.tm_mday, now.tm_hour, now.tm_min, now.tm_sec)
	print s

	GPIOInit()	
	FanOff()
	LightOn()
	pisleep(0.5)
	LightOff()
	pisleep(0.5)
	FanOn()
	pisleep(0.5)
	FanOff()
	
	t = threading.Thread(target=whileloopthread)
	t.start()

if __name__ == '__main__':
	main()
	
		