
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

# -- Photos -- #

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

# -- Musiques -- #

nbMusiquesWeb=$(ls Obsession/web/bundles/obsessionmain/music/ | wc -l)
nbMusiquesSrc=$(ls Obsession/src/ObsessionMainBundle/Resources/public/music/ | wc -l)
musiquesWeb=(`ls -t Obsession/web/bundles/obsessionmain/music/`)
musiquesSrc=(`ls -t Obsession/src/ObsessionMainBundle/Resources/public/music/`)

if [ $nbMusiquesWeb != $nbMusiquesSrc ]
then
	# -- Une musique à été ajoutée -- #
	if [ $nbMusiquesWeb > $nbMusiquesSrc ]
	then
		i=0
		while [ "$i" -lt "${#musiquesWeb[*]}" ]
		do
			if [[ ! ${musiquesSrc[*]} =~ "${musiquesWeb[$i]}" ]]
			then
				cp  Obsession/web/bundles/obsessionmain/music/${musiquesWeb[$i]} Obsession/src/ObsessionMainBundle/Resources/public/music/${musiquesWeb[$i]}
			fi
			((i++))
		done
	fi

	# -- Une musique à été supprimée -- #
	if [ $nbMusiquesWeb < $nbMusiquesSrc ]
        then
		j=0
                while [ "$j" -lt "${#musiquesSrc[*]}" ]
                do
                        if [[ ! ${musiquesWeb[*]} =~ "${musiquesSrc[$j]}" ]]
                        then
                                rm  Obsession/src/ObsessionMainBundle/Resources/public/music/${musiquesSrc[$j]}
                        fi
                        ((j++))
                done

	fi
fi

# --Images Accueil -- #

nbImagesWeb=$(ls Obsession/web/bundles/obsessionmain/img/images-accueil/ | wc -l)
nbImagesSrc=$(ls Obsession/src/ObsessionMainBundle/Resources/public/img/images-accueil/ | wc -l)
imagesWeb=(`ls -t Obsession/web/bundles/obsessionmain/img/images-accueil/`)
imagesSrc=(`ls -t Obsession/src/ObsessionMainBundle/Resources/public/img/images-accueil/`)

if [ $nbImagesWeb != $nbImagesSrc ]
then
	# -- Une image à été ajoutée -- #
	if [ $nbImagesWeb > $nbImagesSrc ]
	then
		i=0
		while [ "$i" -lt "${#imagesWeb[*]}" ]
		do
			if [[ ! ${imagesSrc[*]} =~ "${imagesWeb[$i]}" ]]
			then
				cp  Obsession/web/bundles/obsessionmain/img/images-accueil/${imagesWeb[$i]} Obsession/src/ObsessionMainBundle/Resources/public/img/images-accueil/${imagesWeb[$i]}
			fi
			((i++))
		done
	fi

	# -- Une image à été supprimée -- #
	if [ $nbImagesWeb < $nbImagesSrc ]
        then
		j=0
                while [ "$j" -lt "${#imagesSrc[*]}" ]
                do
                        if [[ ! ${imagesWeb[*]} =~ "${imagesSrc[$j]}" ]]
                        then
                                rm  Obsession/src/ObsessionMainBundle/Resources/public/img/images-accueil/${imagesSrc[$j]}
                        fi
                        ((j++))
                done

	fi
fi