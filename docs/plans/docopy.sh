date=`date +"%H.%M"`
folder="ENL-Structure"
target="$HOME/Téléchargements/Copies/"

#cp ENL-MCD.md $target/CP-MCD-$date.md
cp ENL-Plan.md $target/CP-Plan-$date.md
cp -r ./ENL-Structure $target/CP-Structure-$date
#cp ENL-Tests.md $target/CP-Tests-$date.md

echo "Copie du dossier $folder.md - $date"