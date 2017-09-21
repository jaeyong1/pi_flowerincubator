#!/usr/bin/env python
import os;
import time
import urllib2 
import datetime
def isexist_passwordfile():
	curpath = os.path.dirname(os.path.abspath(__file__)) #this file path
	if (os.path.isfile(curpath + "/ftppassword.txt") == False):
		print("Password file not exist!!")
		print("Path : " + curpath + "/ftppassword.txt")
		return False
	
	return True
	
def takepicture_ftpuplod():
	try:
		#curpath = os.path.dirname(os.path.abspath(__file__))  #this file path
		curpath = os.getcwd()  #current running path
		#print curpath
		now = time.localtime()	
		s = "%04d-%02d-%02d_%02d-%02d-%02d" % (now.tm_year, now.tm_mon, now.tm_mday, now.tm_hour, now.tm_min, now.tm_sec)
		print s
		shellcmd = "raspistill -o " + curpath + "/"+ s +".jpg"
		#print shellcmd
		print("take picture after 5 sec")
		os.system(shellcmd)
		
		print("resize image")
		#convert 2017-08-28_16-10-09.jpg -resize 1024 2017-08-28_16-10-09.jpg #width:1024
		resizecmd = "convert " + curpath + "/"+ s +".jpg -resize 1024 " + curpath + "/"+ s +".jpg"
		os.system(resizecmd)
		
		print("try to upload pic file")
		os.system("sshpass -f " + curpath + "/ftppassword.txt scp " + curpath + "/"+ s +".jpg jaeyong1@jaeyong1.cafe24.com:www/garden/pictures")

		os.system("rm " + curpath + "/"+ s +".jpg")
		print("upload complete")
		return True
		
	except:
		print("takepicture_ftpuplod() failed")
		return False
 
 

def main():
	if (isexist_passwordfile()==False):
		print("password file not exist!!")
		exit()
	takepicture_ftpuplod()

if __name__ == '__main__':
	main()
	
		