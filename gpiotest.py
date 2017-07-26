import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BCM)

print "Setup LED pins as outputs"

#GPIO.setup(14, GPIO.OUT)
#GPIO.output(14, False)
GPIO.setup(15, GPIO.OUT)
GPIO.output(15, False)

#GPIO.output(14, True)
GPIO.output(15, True)

time.sleep(1) #1sec

#GPIO.output(14, False)
GPIO.output(15, False)

raw_input('press enter to exit program')

GPIO.cleanup()

