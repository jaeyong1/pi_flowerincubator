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
from c_incubator import *
from getht import *
from getsetcurrentstate import *
me = singleton.SingleInstance() #singleton process

LONGSLEEPDURATION = 20 #30 sec, uses when there is no new command
SHORTSLEEPDURATION = 2 #2 sec, uses after command processing
PICTUREUPLOADDURATION = 3600 #3600sec, every 1 hour, take picture and upload to ftp server
global incubator

def processcommand(command):
	global incubator
	if command.strip().upper() == "FAN OFF":
		FanOff()
		incubator.fan = 0
		setserverstate(incubator)
	elif command.strip().upper() == "FAN ON":
		FanOn()
		incubator.fan = 1
		setserverstate(incubator)
	elif command.strip().upper() == "LAMP ON":
		LightOn()
		incubator.lamp = 1
		setserverstate(incubator)
	elif command.strip().upper() == "LAMP OFF":
		LightOff()
		incubator.lamp = 0
		setserverstate(incubator)
	else:
	  print("cannot process command")


def getcommand():	
	#current date time ( 2017-01-01 13:23:45 )
	print("---------------------")
	now = time.localtime()	
	s = "%04d-%02d-%02d %02d:%02d:%02d" % (now.tm_year, now.tm_mon, now.tm_mday, now.tm_hour, now.tm_min, now.tm_sec)
	print s
	hasdata = "0"
	
	try:
		print("get command from db by xml")
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
			
	except:
		print("Faile to access the server!!")
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
		if (takepicture_ftpuplod()==True):
			return now
		else:
			return lastuploaded
	else:
		print("do not upload new image")
		return lastuploaded
	
def updatehumidtemp():
	lst=["",""]
	if (get_humidity_temperature(lst) == True):
		humidity = float(lst[0])
		temperature = float(lst[1])
		print("[fl] humidity = " + str(humidity))
		print("[fl] temperature = " + str(temperature))
		ischanged = False
		global incubator
		if (abs(float(incubator.humidity) - humidity)>=0.1):
			incubator.humidity = humidity
			ischanged = True;
		if (abs(float(incubator.temperature) - temperature)>=0.1):
			incubator.temperature = temperature
			ischanged = True;
		if(ischanged == True):
			setserverstate(incubator)

			
	
def whileloopthread():
	td_init = timedelta(seconds = (PICTUREUPLOADDURATION + 100))
	lastuploaded = datetime.now() - td_init
	while True:
		updatehumidtemp()
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
	now = time.localtime()
	s = "%04d-%02d-%02d %02d:%02d:%02d" % (now.tm_year, now.tm_mon, now.tm_mday, now.tm_hour, now.tm_min, now.tm_sec)
	print s

	#init operation
	GPIOInit()	
	FanOff()
	LightOn()
	pisleep(0.5)
	LightOff()
	pisleep(0.5)
	FanOn()
	pisleep(0.5)
	FanOff()
	
	#get previous status from server
	print("get previous status from server")
	global incubator
	incubator = getserverstate()
	print(incubator.lamp)
	print(incubator.fan)
	print(incubator.humidity)
	print(incubator.temperature)
	if(incubator.lamp=='1'):
		LightOn()
			
	if (incubator.fan=='1'):
		FanOn()
	
	t = threading.Thread(target=whileloopthread)
	t.start()

if __name__ == '__main__':
	main()
	
		