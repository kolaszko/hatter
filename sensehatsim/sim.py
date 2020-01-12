from random import random
import json

def tripleRandom():
    return [random(), random(), random()]

def main():
    data = [
        {
            "id" : "gyro",
            "values" : tripleRandom()
        },
                {
            "id" : "acc",
            "values" : tripleRandom()
        },
        {
            "id" : "comp",
            "values" : tripleRandom()
        },
        {
            "id" : "temp",
            "values" : [random()]
        },
        {
            "id" : "humidity",
            "values" : [random()]
        },
        {
            "id" : "pressure",
            "values" : [random()]
        },
    ]
    print(json.dumps(data))


if __name__ == '__main__':
    main()