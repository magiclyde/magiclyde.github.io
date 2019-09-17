## What Is It?
Beanstalk is a simple, fast work queue.  
more and see https://beanstalkd.github.io

## Core 

    生产者(producer) -> 管道(tube) -> 任务(job) -> 消费者 (consumer)

- tube：消息通道，类似于 kafka 里面的 topic, 用来存储某一类或者业务的任务，每个 tube 可有多个 job
- job：生产和消费的基本单元，每个 job 都会有一个 id 和 优先级，以及不同状态

> Job Status

       put with delay               release with delay
      ----------------> [DELAYED] <------------.
                            |                   |
                     kick   | (time passes)     |
                            |                   |
       put                  v     reserve       |       delete
      -----------------> [READY] ---------> [RESERVED] --------> *poof*
                           ^  ^                |  |
                           |   \  release      |  |
                           |    `-------------'   |
                           |                      |
                           | kick                 |
                           |                      |
                           |       bury           |
                        [BURIED] <---------------'
                           |
                           |  delete
                            `--------> *poof*


## Installation

    $ git clones https://github.com/beanstalkd/beanstalkd.git
    $ cd beanstalkd
    $ make
    $ ./beanstalkd -h
    Use: ./beanstalkd [OPTIONS]

    Options:
     -b DIR   write-ahead log directory
     -f MS    fsync at most once every MS milliseconds (use -f0 for "always fsync")
     -F       never fsync (default)
     -l ADDR  listen on address (default is 0.0.0.0)
     -p PORT  listen on port (default is 11300)
     -u USER  become user and group
     -z BYTES set the maximum job size in bytes (default is 65535, max allowed is 1073741824)
     -s BYTES set the size of each write-ahead log file (default is 10485760)
                (will be rounded up to a multiple of 4096 bytes)
     -v       show version information
     -V       increase verbosity
     -h       show this help
    
## Run It

    ./beanstalkd -l 127.0.0.1 -p 11300

## Use It With Php

### Install Client Libraries

    composer require pda/pheanstalk

### Usage Example

    <?php

    use Pheanstalk\Pheanstalk;

    // Create using autodetection of socket implementation
    $pheanstalk = Pheanstalk::create('127.0.0.1');

    // ----------------------------------------
    // producer (queues jobs)

    $pheanstalk
      ->useTube('testtube')
      ->put("job payload goes here\n");

    // ----------------------------------------
    // worker (performs jobs)

    $job = $pheanstalk
      ->watch('testtube')
      ->ignore('default')
      ->reserve();

    echo $job->getData();

    $pheanstalk->delete($job);


## Refer
https://github.com/beanstalkd/beanstalkd  
https://github.com/pheanstalk/pheanstalk  
