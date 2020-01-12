from sense_hat import SenseHat
from random import randint
import math
import sys
import json 

def main():

    sense = SenseHat()
    sense.set_imu_config(True, True, True)

    gyro = sense.get_gyroscope_raw()
    acc = sense.get_accelerometer_raw()
    comp = sense.get_compass_raw()
    temp = sense.temp
    humidity = sense.humidity
    pressure = sense.pressure

    data = [
        {
            "id" : "gyro",
            "values" : [gyro['x'], gyro['y'], gyro['z']]
        },
                {
            "id" : "acc",
            "values" : [acc['x'], acc['y'], acc['z']]
        },
        {
            "id" : "comp",
            "values" : [comp['x'], comp['y'], comp['z']]
        },
        {
            "id" : "temp",
            "values" : [temp]
        },
        {
            "id" : "humidity",
            "values" : [humidity]
        },
        {
            "id" : "pressure",
            "values" : [pressure]
        }
    ]
    print(json.dumps(data))

if __name__ == '__main__':
    main()