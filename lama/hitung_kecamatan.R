#!/usr/bin/Rscript
rm(list = ls())

library(rgdal)
library(sp)
library(raster)
library(geosphere)
library(stringr)

load("Data_SHP_BIG/kec2.Rda")
dt = read.csv(file = "gempa_proses.txt", header = F, sep = "|") 
dt = as.matrix(dt[1,])
tanggal = as.vector(dt[,2]) 
tanggal = as.POSIXct(tanggal) + (8*3600)
bul = month.abb[as.integer(substr(tanggal, 6, 7))]
waktu = paste0(substr(tanggal, 9, 10), "-",bul, "-", substr(tanggal, 1, 4)," ", 
       substr(tanggal, 12, 19), " WITA")

Magnitudo = as.numeric(dt[,5])

lat = as.numeric(strsplit(dt[,8], split = " " )[[1]][2])
SU = as.character(strsplit(dt[,8], split = " " )[[1]][3])

if(SU == "S"){
  lat = -1*lat
  ngidul = paste0(abs(lat), " LS")
}else{
  lat = lat
  ngidul = paste0(abs(lat), " LU")
}

lng = as.numeric(strsplit(dt[,9], split = " " )[[1]][2])
BT = as.character(strsplit(dt[,9], split = " " )[[1]][3])
if(BT == "E"){
  lng = lng
  ngetan = paste0(lng, " BT")
}else{
  lng = lng
  ngetan = paste0(lng, " BB")
}
Magnitudo = sprintf("%.1f", round(Magnitudo, 1))

#messagenya = paste0("Info Gempa Mag: ", Magnitudo, " SR, ",waktu, ", Lok: ", ngidul, "-" ,ngetan)
messagenya = paste0(Magnitudo,"|",waktu,"|",ngidul,"|",ngetan,"|")
lonlat = data.frame(lng = lng, lat = lat)
coordinates(lonlat) = ~lng+lat
crs(lonlat) = crs(kec)
ada = over(lonlat, kec)
mana = as.character(as.matrix(ada[,1]))
lng = c()
lat = c()
for(i in 1:length(kec)){
  lng[i] = kec@polygons[[i]]@labpt[1]
  lat[i] = kec@polygons[[i]]@labpt[2]
}
SULSEL_POINT = data.frame(x = lng, y = lat, Kec = kec$Kecamatan, Kab = kec$Kabupaten, Prov = kec$Provinsi)



if( !is.na(mana) ){
  darat = 1
}else{
  darat = 0
}


R = 6371 # Jari2 Bumi
toRad = function(x){
  y = x*(pi/180)
  return(y)
}

dari_arah_mana = function(dd){
  if(dd >= 0 & dd < 22.5){
    dd = "Utara"
  }else if(dd >= 337.5 & dd <= 360){
    dd = "Utara"
  }else if(dd >= 22.5 & dd < 67.5){
    dd = "Tenggara"
  }else if(dd >= 67.5 & dd < 112.5){
    dd = "Timur"
  }else if(dd >= 112.5 & dd < 157.5){
    dd = "Timur Laut"
  }else if(dd >= 157.5 & dd < 202.5){
    dd = "Selatan"
  }else if(dd >= 202.5 & dd < 247.5){
    dd = "Barat Daya"
  }else if(dd >= 247.5 & dd < 292.5){
    dd = "Barat"
  }else if(dd >= 292.5 & dd < 337.5){
    dd = "Barat Laut"
  }
  return(dd)
}
xy = lonlat
mencari_titik_terdekat = function(xy){
  x = toRad(as.numeric(as.matrix(xy$lng)))
  y = toRad(as.numeric(as.matrix(xy$lat)))
  
  jarak = c()
  for(i in 1:dim(SULSEL_POINT)[1]){
    x2 = toRad(SULSEL_POINT$x[i])
    y2 = toRad(SULSEL_POINT$y[i])
    jarak[i] = acos((sin(y)* sin(y2)) + (cos(y) * cos(y2) * cos(x - x2)))* R
  }
  all_data = data.frame(cbind(SULSEL_POINT, Jarak = jarak))
  all_data = all_data[order(jarak),]
  vicinity = c(as.matrix(unique(all_data$Kab)[1:5]))
  dt_vcnt = list()
  for(i in 1:length(vicinity)){
    vic = all_data[all_data$Kab == vicinity[i],]
    dt_vcnt[[i]] = vic[vic$Jarak == min(vic$Jarak),]
  }
  gempa = cbind(lng = as.numeric(as.matrix(xy$lng)), lat = as.numeric(as.matrix(xy$lat)))
  lngx = c()
  laty = c()
  for(i in 1:length(dt_vcnt)){
    lngx[i] = dt_vcnt[[i]]$x
    laty[i] = dt_vcnt[[i]]$y
  }
  
  kecamatan = cbind(lng = lngx, lat = laty )
  arah = c()
  directiong = c()
  dimana = c()
  jrk = c()
  hasil = matrix(0, ncol = length(dt_vcnt[[1]])+1, nrow = length(dt_vcnt))
  for(i in 1:dim(kecamatan)[1]){
    arah[i] = finalBearing(kecamatan[i,],gempa)
    if(arah[i] < 0){
      arah[i] = 360 + arah[i]
    }
    directiong[i] = dari_arah_mana(arah[i])
    sip = dt_vcnt[[i]] # <
    sip = cbind(sip,  Arah = directiong[i]) # <
    hasil[i,] =  as.matrix(sip)
    dimana[i] = paste(as.matrix(hasil[i,3:5]), collapse = ", ")
    jrk[i] = as.integer(sip$Jarak)
    if(jrk[i] == 0){
      jrk[i] = 1
    }
    
    # jrk[i] = sprintf('%.2f',sip$Jarak)
  }
  list_lokasi = cbind(Jarak = jrk," Km ", Arah = directiong," Kec. ", Lokasi = str_to_title(dimana) )
  vicend = c()
  for(i in 1:length(jrk)){
    vicend[i] = paste(list_lokasi[i,], collapse = "")
  }
  
  return(vicend)
}

xy = lonlat
dep = as.character(as.matrix(dt[,10]))
hhhh = mencari_titik_terdekat(xy)
if(darat == 1){  
  messagex = paste0(messagenya,"darat","|",paste(hhhh, collapse = "|"),"|",dep,"|","BMKG-PGRIV")
}else{
  messagex = paste0(messagenya,"laut","|",paste(hhhh, collapse = "|"),"|",dep,"|","BMKG-PGRIV")
}

write.table(file = "gempa_hasil.txt", messagex, col.names = F, row.names = F)
file.create("gempa_proses.txt")

