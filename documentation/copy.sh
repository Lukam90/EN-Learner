date=`date +"%H.%M"`
target="$HOME/Téléchargements/Copies/CP-ENLDocs-$date"

cp ENL-Slides.odp $target.odp
cp -r bonus $target
cp -r memo $target

echo "Copie du dossier CP-Bonus - $date"