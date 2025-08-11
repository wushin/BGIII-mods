#!/bin/bash

CSV_FILE="Daarra"

while IFS=',' read -r -a line_array; do
  spell=${line_array[0]}
  DAARRALEVEL=${line_array[2]}
  name=`echo ${line_array[0]} | sed 's/.*_//g'`
  IFS=$'\n' read -d '' -ra parts <<< "$(sed -E 's/(.)([A-Z])/\1\n\2/g' <<< "$name")"
  content_name=""
  for part in "${parts[@]}"; do
    content_name+=" $part"
  done
#  UUID=`curl -s "http://localhost:8080/uuidcontentuidgen/UUID"`
#  CONTENTUUID=`curl -s "http://localhost:8080/uuidcontentuidgen/ContentUID"`
#  echo '<content contentuid="'$CONTENTUUID'" version="1">Daarra of'$content_name'</content>'
#  cat ../daarra-template | sed "s/HANDLEDAARRA/$CONTENTUUID/g" | sed "s/ICONDAARRA/Item_LOOT_Daarra_$name/g" | sed "s/DAARRAUUID/$UUID/g" | sed "s/OBJDAARRA/OBJ_Daarra_$name/g" | sed "s/SPELLNAME/$spell/g" > ./church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/RootTemplates/$UUID.lsx
#  cat ../Daarra-template | sed "s/DAARRAUUID/$UUID/g" | sed "s/OBJDAARRA/$name/g" | sed "s/DAARRALEVEL/$DAARRALEVEL/g" >> church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Stats/Generated/Data/Object.txt

  for x in `find ../UnpackedData/Game/Public/Game/GUI/Assets/Tooltips/Icons/ -name "${line_array[1]}.DDS"`
  do
    magick composite ../Item_LOOT_Darra_Base.DDS $x church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/Tooltips/ItemIcons/Item_LOOT_Darra_$name.DDS
  done
  for x in `find church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/Tooltips/Icons/ -name "${line_array[1]}.DDS"`
  do
    magick composite ../Item_LOOT_Darra_Base.DDS $x church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/Tooltips/ItemIcons/Item_LOOT_Darra_$name.DDS
  done
  for x in `find ../UnpackedData/Game/Public/Game/GUI/Assets/ControllerUIIcons/skills_png/ -name "${line_array[1]}.DDS"`
  do
    magick composite ../Item_LOOT_Darra_Base-144$DAARRALEVEL.DDS $x church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/ControllerUIIcons/items_png/Item_LOOT_Darra_$name.DDS
    convert church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/ControllerUIIcons/items_png/Item_LOOT_Darra_$name.DDS -resize 64x64 ../stitches/Item_LOOT_Darra_$name.DDS
    ((i++))
    echo '<attribute id="MapKey" type="FixedString" value="'Item_LOOT_Darra_$name'"/>'
  done
  for x in `find church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/ControllerUIIcons/skills_png/ -name "${line_array[1]}.DDS"`
  do
    magick composite ../Item_LOOT_Darra_Base-144$DAARRALEVEL.DDS $x church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/ControllerUIIcons/items_png/Item_LOOT_Darra_$name.DDS
    convert church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/Game/GUI/Assets/ControllerUIIcons/items_png/Item_LOOT_Darra_$name.DDS -resize 64x64 ../stitches/Item_LOOT_Darra_$name.DDS
    ((i++))
    echo '<attribute id="MapKey" type="FixedString" value="'Item_LOOT_Darra_$name'"/>'
  done
done < "$CSV_FILE"
