#!/bin/bash
#screen= 1628.pts-25.pj
while [[ true ]]; do
    php -f update_datagempa.php
    data_masuk=`cat gempa_proses.txt`
    if [ -s gempa_proses.txt ]; then
	    ./hitung_kecamatan.R
    fi
    sleep 1
done


