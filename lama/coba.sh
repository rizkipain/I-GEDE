tgl=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'`
wkt=`grep Time /home/sysop/data/mailexportfile.txt|awk '{ print $2 }' | cut -d "." -f1`

metode=`grep Mode /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'`

phase=`grep "arrivals" /home/sysop/data/mailexportfile.txt|awk '{ print $1 }'`

mag=0.0
kesatu=`grep preferred /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'|cut -c1-1`
if [ "$kesatu" -ge 1 ] ; then
   kedua=`grep preferred /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'|cut -c3-3`
   ketiga=`grep preferred /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'|cut -c4-4`
   if [ "$ketiga" -ge 5 ] ; then
      let kedua=(kedua+1)
      if [ "$kedua" -ge 10 ] ; then
         let kesatu=(kesatu+1)
         kedua=0
      fi
   fi
   mag=`echo $kesatu.$kedua`
fi

stamag=`grep "preferred" /home/sysop/data/mailexportfile.txt|awk '{ print $3 }'`
llbb=`cat /home/sysop/data/latlonluls.txt|awk '{ print $1" "$2 " - " $4" "$5 }'`

lat=`cat /home/sysop/data/latlonluls.txt|awk '{print $1}'`
tanda_lat=`cat /home/sysop/data/latlonluls.txt|awk '{print $2}'`

if [ "$tanda_lat" == "LS" ] ; then
	tanda_lat=S
fi
if [ "$tanda_lat" == "LU" ] ; then
	tanda_lat=U
fi

lon=`cat /home/sysop/data/latlonluls.txt|awk '{print $4}'`
tanda_lon=`cat /home/sysop/data/latlonluls.txt|awk '{print $5}'`

if [ "$tanda_lon" == "BT" ] ; then
	tanda_lon=E
fi
if [ "$tanda_lon" == "BB" ] ; then
	tanda_lon=W
fi

kedalaman=`grep Depth /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'`
lokasi=`grep "region name:" /home/sysop/data/mailexportfile.txt | cut -d ":" -f2`

tahun=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'| cut -d "-" -f1`
bulan=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'| cut -d "-" -f2`
tanggal=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'| cut -d "-" -f3`

#echo "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi

echo -e "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi> /home/sysop/rizki/gempa_baru.txt

FILE=/home/sysop/rizki
if [ ! -f $FILE/$tahun$bulan$tanggal.txt ]; then
    echo "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi > /home/sysop/rizki/$tahun$bulan$tanggal.txt
	
else
    rekap_gempa=`cat /home/sysop/rizki/$tahun$bulan$tanggal.txt`
    gempa_lama=`cat /home/sysop/rizki/gempa_lama.txt` 
    gempa_baru=`cat /home/sysop/rizki/gempa_baru.txt` 
	if [ "$gempa_lama" != "$gempa_baru" ]; then
		echo "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi > /home/sysop/rizki/$tahun$bulan$tanggal.txt 
    		echo "$rekap_gempa">>/home/sysop/rizki/$tahun$bulan$tanggal.txt
		echo "$gempa_baru">/home/sysop/rizki/gempa_lama.txt
	fi
fi

scp /home/sysop/rizki/$tahun$bulan$tanggal.txt pj@172.19.144.246:/home/pj/TEWS_CEKARANG/data
scp /home/sysop/rizki/$tahun$bulan$tanggal.txt gempa@10.20.10.7:/var/www/html/data
tgl=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'`
wkt=`grep Time /home/sysop/data/mailexportfile.txt|awk '{ print $2 }' | cut -d "." -f1`

metode=`grep Mode /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'`

phase=`grep "arrivals" /home/sysop/data/mailexportfile.txt|awk '{ print $1 }'`

mag=0.0
kesatu=`grep preferred /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'|cut -c1-1`
if [ "$kesatu" -ge 1 ] ; then
   kedua=`grep preferred /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'|cut -c3-3`
   ketiga=`grep preferred /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'|cut -c4-4`
   if [ "$ketiga" -ge 5 ] ; then
      let kedua=(kedua+1)
      if [ "$kedua" -ge 10 ] ; then
         let kesatu=(kesatu+1)
         kedua=0
      fi
   fi
   mag=`echo $kesatu.$kedua`
fi

stamag=`grep "preferred" /home/sysop/data/mailexportfile.txt|awk '{ print $3 }'`
llbb=`cat /home/sysop/data/latlonluls.txt|awk '{ print $1" "$2 " - " $4" "$5 }'`

lat=`cat /home/sysop/data/latlonluls.txt|awk '{print $1}'`
tanda_lat=`cat /home/sysop/data/latlonluls.txt|awk '{print $2}'`

if [ "$tanda_lat" == "LS" ] ; then
	tanda_lat=S
fi
if [ "$tanda_lat" == "LU" ] ; then
	tanda_lat=U
fi

lon=`cat /home/sysop/data/latlonluls.txt|awk '{print $4}'`
tanda_lon=`cat /home/sysop/data/latlonluls.txt|awk '{print $5}'`

if [ "$tanda_lon" == "BT" ] ; then
	tanda_lon=E
fi
if [ "$tanda_lon" == "BB" ] ; then
	tanda_lon=W
fi

kedalaman=`grep Depth /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'`
lokasi=`grep "region name:" /home/sysop/data/mailexportfile.txt | cut -d ":" -f2`

tahun=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'| cut -d "-" -f1`
bulan=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'| cut -d "-" -f2`
tanggal=`grep Date /home/sysop/data/mailexportfile.txt|awk '{ print $2 }'| cut -d "-" -f3`

#echo "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi

echo -e "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi> /home/sysop/rizki/gempa_baru.txt

FILE=/home/sysop/rizki
if [ ! -f $FILE/$tahun$bulan$tanggal.txt ]; then
    echo "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi > /home/sysop/rizki/$tahun$bulan$tanggal.txt
	
else
    rekap_gempa=`cat /home/sysop/rizki/$tahun$bulan$tanggal.txt`
    gempa_lama=`cat /home/sysop/rizki/gempa_lama.txt` 
    gempa_baru=`cat /home/sysop/rizki/gempa_baru.txt` 
	if [ "$gempa_lama" != "$gempa_baru" ]; then
		echo "|" $tgl $wkt "|" $metode "|" $phase "|" $mag "|" M "|" $stamag "|" $lat $tanda_lat "|" $lon $tanda_lon "|" $kedalaman km "|" $lokasi > /home/sysop/rizki/$tahun$bulan$tanggal.txt 
    		echo "$rekap_gempa">>/home/sysop/rizki/$tahun$bulan$tanggal.txt
		echo "$gempa_baru">/home/sysop/rizki/gempa_lama.txt
	fi
fi

scp /home/sysop/rizki/$tahun$bulan$tanggal.txt pj@172.19.144.246:/home/pj/TEWS_CEKARANG/data
scp /home/sysop/rizki/$tahun$bulan$tanggal.txt gempa@10.20.10.7:/var/www/html/data
