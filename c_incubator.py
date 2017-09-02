class Incubator:
	lamp = 0
	fan = 0
	humidity = 0.0
	temperature = 0.0
	issetted = 0
	
	def __init__(self, lamp, fan, humidity, temperature):
		self.lamp = lamp
		self.fan = fan
		self.humidity = humidity
		self.temperature = temperature
		self.issetted = 1

	def settingfailed(self):
		self.issetted = 0

			