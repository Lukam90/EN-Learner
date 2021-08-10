date=`date +"%H.%M"`
target="$HOME/Téléchargements/Copies/"

cp -r . $HOME/EN-Learner/docs
cp -r partials $target/CP-Ecrit-$date

echo "Copie du dossier CP-Ecrit - $date"