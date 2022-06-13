date=`date +"%d-%m-%y-T%H.%M"`
target="$HOME/Téléchargements/Copies/CP-ENL-$date"

cp -r . $target

echo "Copie du dossier EN-Learner effectuée - $date"