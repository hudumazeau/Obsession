
#!/bin/bash

# --Affiches -- #

nbAffichesWeb=$(ls Obsession/web/bundles/obsessionmain/img/affiches/HD/ | wc -l)
#echo $nbAffichesWeb
nbAffichesSrc=$(ls Obsession/src/ObsessionMainBundle/Resources/public/img/affiches/HD/ | wc -l)
#echo $nbAffichesSrc
affichesWeb=(`ls -t Obsession/web/bundles/obsessionmain/img/affiches/HD/`)
#echo ${affichesWeb[1]}
affichesSrc=(`ls -t Obsession/src/ObsessionMainBundle/Resources/public/img/affiches/HD/`)

if [ $nbAffichesWeb != $nbAffichesSrc ]
then
	# -- Une affiches à été ajoutée -- #
	if [ $nbAffichesWeb > $nbAffichesSrc ]
	then
		i=0
		while [ "$i" -lt "${#affichesWeb[*]}" ]
		do
			if [[ ! ${affichesSrc[*]} =~ "${affichesWeb[$i]}" ]]
			then
				#echo ${affichesWeb[$i]}
				cp  Obsession/web/bundles/obsessionmain/img/affiches/HD/${affichesWeb[$i]} Obsession/src/ObsessionMainBundle/Resources/public/img/affiches/HD/${affichesWeb[$i]} 
				cp  Obsession/web/bundles/obsessionmain/img/affiches/miniature/${affichesWeb[$i]} Obsession/src/ObsessionMainBundle/Resources/public/img/affiches/miniature/${affichesWeb[$i]} 

			fi
			((i++))
		done
	fi

	# -- Une affiche à été supprimée -- #
	if [ $nbAffichesWeb < $nbAffichesSrc ]
        then
		j=0
                while [ "$j" -lt "${#affichesSrc[*]}" ]
                do
                        if [[ ! ${affichesWeb[*]} =~ "${affichesSrc[$j]}" ]]
                        then
                                #echo ${affichesSrc[$j]}
                                rm  Obsession/src/ObsessionMainBundle/Resources/public/img/affiches/HD/${affichesSrc[$j]} 
				rm  Obsession/src/ObsessionMainBundle/Resources/public/img/affiches/miniature/${affichesSrc[$j]} 
                        fi
                        ((j++))
                done

	fi
fi

# --Couverture -- #

nbCouvWeb=$(ls Obsession/web/bundles/obsessionmain/img/couv-photos/ | wc -l)
nbCouvSrc=$(ls Obsession/src/ObsessionMainBundle/Resources/public/img/couv-photos/ | wc -l)
couvWeb=(`ls -t Obsession/web/bundles/obsessionmain/img/couv-photos/`)
couvSrc=(`ls -t Obsession/src/ObsessionMainBundle/Resources/public/img/couv-photos/`)

if [ $nbCouvWeb != $nbCouvSrc ]
then
	# -- Une couverture à été ajoutée -- #
	if [ $nbCouvWeb > $nbCouvSrc ]
	then
		i=0
		while [ "$i" -lt "${#couvWeb[*]}" ]
		do
			if [[ ! ${couvSrc[*]} =~ "${couvWeb[$i]}" ]]
			then
				cp  Obsession/web/bundles/obsessionmain/img/couv-photos/${couvWeb[$i]} Obsession/src/ObsessionMainBundle/Resources/public/img/couv-photos/${couvWeb[$i]} 
			fi
			((i++))
		done
	fi

	# -- Une couverture à été supprimée -- #
	if [ $nbCouvWeb < $nbCouvSrc ]
        then
		j=0
                while [ "$j" -lt "${#couvSrc[*]}" ]
                do
                        if [[ ! ${couvWeb[*]} =~ "${couvSrc[$j]}" ]]
                        then
                                rm  Obsession/src/ObsessionMainBundle/Resources/public/img/couv-photos/${couvSrc[$j]}
                        fi
                        ((j++))
                done

	fi
fi

# --Photos -- #

nbPhotosWeb=$(ls Obsession/web/bundles/obsessionmain/img/photosGalerie/HD/ | wc -l)
nbPhotosSrc=$(ls Obsession/src/ObsessionMainBundle/Resources/public/img/photosGalerie/HD/ | wc -l)
photosWeb=(`ls -t Obsession/web/bundles/obsessionmain/img/photosGalerie/HD/`)
photosSrc=(`ls -t Obsession/src/ObsessionMainBundle/Resources/public/img/photosGalerie/HD/`)

if [ $nbPhotosWeb != $nbPhotosSrc ]
then
	# -- Une photo à été ajoutée -- #
	if [ $nbPhotosWeb > $nbPhotosSrc ]
	then
		i=0
		while [ "$i" -lt "${#photosWeb[*]}" ]
		do
			if [[ ! ${photosSrc[*]} =~ "${photosWeb[$i]}" ]]
			then
				cp  Obsession/web/bundles/obsessionmain/img/photosGalerie/HD/${photosWeb[$i]} Obsession/src/ObsessionMainBundle/Resources/public/img/photosGalerie/HD/${photosWeb[$i]} 
				cp  Obsession/web/bundles/obsessionmain/img/photosGalerie/miniature/${photosWeb[$i]} Obsession/src/ObsessionMainBundle/Resources/public/img/photosGalerie/miniature/${photosWeb[$i]} 

			fi
			((i++))
		done
	fi

	# -- Une photo à été supprimée -- #
	if [ $nbPhotosWeb < $nbPhotosSrc ]
        then
		j=0
                while [ "$j" -lt "${#photosSrc[*]}" ]
                do
                        if [[ ! ${photosWeb[*]} =~ "${photosSrc[$j]}" ]]
                        then
                                rm  Obsession/src/ObsessionMainBundle/Resources/public/img/photosGalerie/HD/${photosSrc[$j]} 
				rm  Obsession/src/ObsessionMainBundle/Resources/public/img/photosGalerie/miniature/${photosSrc[$j]} 
                        fi
                        ((j++))
                done

	fi
fi

