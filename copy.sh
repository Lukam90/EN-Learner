date=`date +"%d-%m-%y-T%H.%M"`

cp -r app ~/EN-Learner/
cp -r docs ~/EN-Learner/

cp .htaccess ~/EN-Learner/
cp copy.sh ~/EN-Learner/
cp root.txt ~/EN-Learner/

cp -r . ~/Téléchargements/Archives/CP-ENL-$date

echo "Copie du dossier EN-Learner effectuée - $date"