
#!/bin/bash

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
