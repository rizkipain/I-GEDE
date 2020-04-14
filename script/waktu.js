function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function checkBulan(i) {
	i = i+1;
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
	
	    var weekday = new Array(7);
			weekday[0] = "Minggu";
			weekday[1] = "Senin";
			weekday[2] = "Selasa";
			weekday[3] = "Rabu";
			weekday[4] = "Kamis";
			weekday[5] = "Jumat";
			weekday[6] = "Sabtu";
		
		var month = new Array();
			month[0] = "Januari";
			month[1] = "Februari";
			month[2] = "Maret";
			month[3] = "April";
			month[4] = "Mei";
			month[5] = "Juni";
			month[6] = "Juli";
			month[7] = "Agustus";
			month[8] = "September";
			month[9] = "Oktober";
			month[10] = "November";
			month[11] = "Desember";
		

    var hari = weekday[today.getDay()];
	var tanggal = checkTime(today.getDate());
	var bulan = checkBulan(today.getMonth());
	var tahun = checkTime(today.getFullYear());
    // add a zero in front of numbers<10
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('jam').value = h + ":" + m + ":" + s;
    t = setTimeout(function () {
        startTime()
    }, 500);
}
startTime();