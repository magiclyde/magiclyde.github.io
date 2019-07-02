#coing=utf-8

def consume():
    while True:
        data = yield
        print('consume: ', data)


consumer = consume()

next(consumer)

for i in range(0, 50):
    print('procuct: ', i)
    consumer.send(i)

