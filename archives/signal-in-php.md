## signal in php

    <?php
    	
    /**
      * ==================================================================
      * signal in php
      * ==================================================================
      */

    // tick use required as of PHP 4.3.0
    // declare(ticks = 1);

    function sig_handler($signo)
    {

        switch ($signo) {
            case SIGTERM:
            	// handle shutdown tasks, "kill pid"
            	exit;
            	break;

            case SIGINT:
            	// Terminal interrupt, "ctrl+c"
            	exit;
            	break;

            case SIGHUP:
            	// Hangup or handle restartable tasks, " /bin/kill -s HUP pid"
            	break;

            case SIGUSR1:
            	// User defined signal 1 (POSIX), "kill -USR1 `pidof myapp`"
            	echo "Caught SIGUSR1...\n";
            	break;

            case SIGUSR2:
            	// User defined signal 2 (POSIX), "kill -USR2 `pidof myapp`"
            	echo "Caught SIGUSR2...\n";
            	break;

            //case SIGKILL:
            //  force shutdown tasks, "kill -9 pid", 
            //  it can NOT be caught and should not be here.
            //	exit;
            //	break;

            default:
            	// handle all other signals
        }

    }

    pcntl_signal(SIGTERM, 'sig_handler');
    pcntl_signal(SIGINT, 'sig_handler');

    // for php >= 5.3.0, use pcntl_signal_dispatch instead of declare(ticks = 1)
    while(true){
    	// Dispatching signal queue
    	pcntl_signal_dispatch();
    	
    	// todo...
    }

## refer
http://php.net/manual/en/function.pcntl-signal.php  
http://php.net/manual/en/function.pcntl-signal-dispatch.php  
http://rango.swoole.com/archives/364  
http://www.comptechdoc.org/os/linux/programming/linux_pgsignals.html  
http://www.cnblogs.com/vamei/archive/2012/10/07/2713023.html  
https://stackoverflow.com/questions/10824886/how-to-signal-an-application-without-killing-it-in-linux   
http://asika.windspeaker.co/post/3494-php-daemon-unix-signal  