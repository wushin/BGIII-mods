#!/bin/bash

localhandles=`grep -I -e "DisplayName" -e "Description" -R $1 | grep -v "Params" | grep -v "Boosts" | grep -v "ProgressionDescriptions" | grep -v "ClassDescriptions" | sed 's/"/ /g' | sed 's/;/\ /g' | sed 's/<attribute id= Description  type= TranslatedString  handle= //g' | sed 's/<attribute id= DisplayName  type= TranslatedString  handle= //g' | sed 's/data  DisplayName//g' | grep -v "meta.lsx" | grep -v ".khn" | sed 's/data  Description//g' | grep -v "png" | sed 's/data  TooltipUpcastDescription//g' | sed 's/data  ExtraDescription//g' | sed 's/ version= //g' | sed 's/\/>//g' | sed 's/\s*\s/ /g' | awk '{print $2}' | grep -v "-"`

localtooltips=`grep -I -e "DisplayName" -e "Description" -R $1 | grep -v "Params" | grep -v "Boosts" | grep -v "ProgressionDescriptions" | grep -v "ClassDescriptions" | sed 's/"/ /g' | sed 's/;/\ /g' | sed 's/<attribute id= Description  type= TranslatedString  handle= //g' | sed 's/<attribute id= DisplayName  type= TranslatedString  handle= //g' | sed 's/data  DisplayName//g' | grep -v "meta.lsx" | grep -v ".khn" | sed 's/data  Description//g' | grep -v "png" | sed 's/data  TooltipUpcastDescription//g' | sed 's/data  ExtraDescription//g' | sed 's/ version= //g' | sed 's/\/>//g' | sed 's/\s*\s/ /g' | awk '{print $2}'| grep "-" | sort -u`

englishxml=$(find $1 -name "english.xml")
coreenglishxml=$(find $2 -name "english*xml")

echo "Update these Entries to a non-conflicting Handle:"
echo ""

#for x in $localhandles
#do
#  grep -R $x $coreenglishxml || find $3 -name "english.xml" -exec grep -R $x {} \;
#done | sed 's///g' | sort -u 

#echo '<?xml version="1.0"?>' > english.xml.tmp
#echo '<contentList xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' >> english.xml.tmp
#for x in $localhandles
#do
#  grep -R $x $englishxml || grep -R $x $coreenglishxml || find $3 -name "english.xml" -exec grep -R $x {} \;
#done | sed 's///g' | sort -u >> english.xml.tmp
#echo '</contentList>' >> english.xml.tmp

for x in $localtooltips
do
  echo $x
done
