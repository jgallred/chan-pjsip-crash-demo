#!/usr/bin/env bash

ret=0
i=0
while [ $i -lt 50 -a $ret -eq 0 ]
do
    docker-compose exec -T php ./trigger_segfault.php
    ret=$?
    i=$[$i+1]
done

echo "$i"
echo "$ret"
