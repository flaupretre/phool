#
# Appelle phpxref en se mettant dans le repertoire d'install de phpxref.
# Si on l'appelle a partir d'un autre repertoire, le resultat n'inclut pas les
# feuilles de style.
# Ce wrapper permet de ne pas mettre le repertoire en dur dans le fichier de
# config
# Variables :
# INPUT = Repertoire des sources (relatif par rapport au repertoire du script)
# OUTPUT = repertoire resultat (absolu)
# PHPXREF_DIR = repertoire d'install de phpxref
#
# $1 = Config file

if [ -z "$PHPXREF" ] ; then
	echo "PHPXREF is not defined"
	exit 1
fi

TMP=/tmp/.t$$
/bin/rm -rf $TMP

save_wd=`pwd`
cd $INPUT
SOURCE=`pwd`
cd $save_wd

(
echo "SOURCE=$SOURCE"
echo "OUTPUT=$OUTPUT"
grep -v '^SOURCE=' <$1 | grep -v 'OUTPUT='
) >$TMP

cd $PHPXREF
perl phpxref.pl -c $TMP

#/bin/rm -f $TMP

exit 0
