# PJSIP Segfault Test

1. Build containers (compiling asterisk takes a while)

        docker-compose build

1. Run containers
    
        docker-compose up
    
1. Trigger bug (may require a few tries)

        docker-compose exec php ./trigger_segfault.php
    
1. Process core dump(s)

        docker-compose exec asterisk /var/lib/asterisk/scripts/ast_coredumper