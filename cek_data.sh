#!/bin/bash

#screen= 1628.pts-25.pj
while [[ true ]]; do

FILE=/var/www/html/new

baru=`ls new/ | tail -n1`
waktu_data_baru_masuk=`cat new/$baru | tail -n1|awk '{ print $3 }'`
data_baru_masuk=`cat new/$baru | tail -n1`

echo $waktu_data_baru_masuk

waktu_data_terakhir=`cat gempa_lama.txt|awk '{ print $3 }'`
echo $waktu_data_terakhir
#cek jika ada data baru TIDAK SAMA dengan waktu data gempa terakhir maka simpan

    if [ "$waktu_data_baru_masuk" == "$waktu_data_terakhir" ]; then
        echo "sama"
    else
        echo "$data_baru_masuk" > "gempa_lama.txt"
	echo "$data_baru_masuk" > "simpan_ini.txt"
	php masukan_ke_database.php
    fi
    sleep 1
done
