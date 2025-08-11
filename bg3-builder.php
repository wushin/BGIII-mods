#!/usr/bin/php
<?php

$lines = file('MyMods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Mods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Localization/English/english.xml');
array_pop($lines);
$content_file = implode("", $lines);

$abilities = ['Strength', 'Dexterity', 'Constitution', 'Intelligence', 'Wisdom', 'Charisma'];
$skills = [
    'Athletics', 'Acrobatics', 'Sleight of Hand', 'Stealth',
    'Arcana', 'History', 'Investigation', 'Nature', 'Religion',
    'Animal Handling', 'Insight', 'Medicine', 'Perception', 'Survival',
    'Deception', 'Intimidation', 'Performance', 'Persuasion'
];

$resistant = ['Slashing','Piercing','Bludgeoning','Acid','Thunder','Fire','Lightning','Cold','Poison','Necrotic','Psychic','Force','Radiant'];

$advantage = ['Ability','Skill','SavingThrow'];

$treasure_table = '';
$treasure_tables = array();
// Vendors
$treasure_tables_to_tables = array(
  'ST_SimpleMeleeWeapons_1' => array('WPN_Dagger'),
  'ST_Finesse_MeleeWeapons_Magic' => array('WPN_Dagger','WPN_Rapier','WPN_Scimitar','WPN_Shortsword'),
  'ST_MartialMeleeWeapons_1' => array('WPN_Rapier','WPN_Scimitar','WPN_Shortsword','WPN_Longsword','WPN_Greatsword'),
  'EquipmentTrader_BodyArmor_Light_Magic' => array('ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_StuddedLeather_Body'),
  'ST_Generic_Magic_LightArmor_ACT2_A' => array('ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_StuddedLeather_Body'),
  'ST_Generic_Magic_LightArmor_ACT2_B' => array('ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_StuddedLeather_Body','ARM_ElvenChain'),
  'EquipmentTrader_SecondaryArmor' => array('ARM_Monk','ARM_Circlet','ARM_Shoes','ARM_Cloak'),
  'EquipmentTrader_SecondaryArmor_Leather' => array('ARM_Gloves_Leather','ARM_Boots_Leather'),
  'GOB_Quartermaster' => array('ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_Circlet','ARM_Shoes','ARM_Cloak'),
  'MOO_ZhentQuartermaster' => array('WPN_Scimitar','WPN_Shortsword','WPN_Longsword','ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_ElvenChain','ARM_Circlet','ARM_Shoes','ARM_Cloak'),
  'UND_MycoVillage_AlchemistDwarf_Trade' => array('ARM_Monk','ARM_Shoes'),
  'UND_SocietyOfBrilliance_Hobgoblin' => array('ARM_Circlet','ARM_Cloak'),
  'UND_SocietyOfBrilliance_Mindflayer' => array('ARM_Ring','ARM_Amulet'),
  'CRE_Expeditioner_Magic_Trade' => array('ARM_Monk','ARM_Shoes','ARM_Amulet','ARM_Robe_Body'),
  'CRE_MagicItem_Gith_Trader' => array('WPN_Dagger','WPN_Longsword','WPN_Greatsword','ARM_Gloves_Leather','ARM_Boots_Leather'),
  'HAV_HarperQuarterMaster_Magic_Trade' => array('ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_StuddedLeather_Body','ARM_Gloves_Leather','ARM_Circlet','ARM_Cloak'),
  'HAV_Thiefling_Trade' => array('ARM_Ring'),
  'WYR_Thiefling_Trade' => array('ARM_Ring','ARM_Amulet','ARM_Circlet'),
  'WYR_Danthelon_Trader' => array('ARM_Robe_Body','ARM_Ring','ARM_Amulet','ARM_Circlet','ARM_Monk','ARM_Shoes','ARM_Cloak'),
  'WYR_Ironhand_Magic_Merchant' => array('ARM_Monk','ARM_Gloves_Leather'),
  'WYR_Bridge_Trader_Clothes' => array('ARM_Robe_Body','ARM_Monk','ARM_Shoes','ARM_Cloak'),
  'LOW_SorcerousSundries_Trade_Magic' => array('ARM_Robe_Body','ARM_Circlet','ARM_Shoes','ARM_Cloak','ARM_Ring','ARM_Amulet'),
  'LOW_SteepsTrader_Weapons' => array('WPN_Dagger','WPN_Rapier','WPN_Scimitar','WPN_Shortsword','WPN_Longsword','WPN_Greatsword'),
  'LOW_SteepsTrader_Armor' => array('ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_StuddedLeather_Body','ARM_ElvenChain','ARM_Gloves_Leather','ARM_Boots_Leather'),
  'LOW_DevilsFee_Diabolist_Trade_Magic' => array('ARM_Monk','ARM_Shoes','ARM_Cloak'),
  'LOW_Figaro_Trade' => array('ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_Monk','ARM_Shoes','ARM_Cloak','ARM_Gloves_Leather','ARM_Boots_Leather'),
  'LOW_Weaponsmith_Trade' => array('WPN_Dagger','WPN_Longsword','WPN_Greatsword','ARM_Gloves_Leather','ARM_Boots_Leather','ARM_Robe_Body','ARM_Padded_Body','ARM_Leather_Body','ARM_StuddedLeather_Body','ARM_ElvenChain','ARM_Circlet','ARM_Cloak'),
  'ST_GEN_Valuables_Ring_Silver' => array('ARM_Ring'),
  'ST_GEN_Valuables_Necklace_Silver' => array('ARM_Amulet'),
  'ST_GEN_Valuables_Jewelry_Silver' => array('ARM_Ring','ARM_Amulet'),
  'Valuables_Jewelry' => array('ARM_Ring','ARM_Amulet'),
  'LOW_JewelTrader' => array('ARM_Ring','ARM_Amulet','ARM_Circlet'),
  'LOW_MusicTrader' => array('ARM_Instrument'),
  'ST_MusicInstrument_Rare' => array('ARM_Instrument')
);

$treasure_tables_to_drops = array(
  'BGO_MagicArmor_FlamingFist_Armory' => array('ARM_StuddedLeather_Body_Rare','ARM_Gloves_Leather_Uncommon','ARM_Boots_Leather_Uncommon'),
  'CHA_Exterior_Bandit_Leader' => array('ARM_Leather_Body_Uncommon'),
  'CHA_Exterior_Bandit_Caster' => array('ARM_Robe_Body_Uncommon'),
  'CHA_Container_Treasure' => array('ARM_Ring_Uncommon'),
  'CRA_HarperTreasureBox' => array('ARM_Amulet_Uncommon'),
  'CRE_Axemaster_Buried_Chest' => array('ARM_Ring_Uncommon'),
  'CRE_TreasuryVault_4_Treasure' => array('ARM_Monk_Uncommon','ARM_Shoes_Uncommon'),
  'DEN_Harpy_Nest' => array('ARM_Circlet_Uncommon'),
  'FOR_DeathOfATrueSoul_SeluneStash' => array('ARM_Circlet_Uncommon','ARM_Cloak_Rare'),
  'FOR_ThayanCellar_JewelledChest_Treasure' => array('WPN_Dagger_Uncommon'),
  'GOB_Goblin_Generic_Rare' => array('ARM_Leather_Body_Uncommon'),
  'GOB_King_MagicItems' => array('ARM_Robe_Body_Rare'),
  'GOB_Minthara_Chest' => array('ARM_StuddedLeather_Body_Rare','ARM_Boots_Leather_Uncommon','ARM_Monk_Uncommon'),
  'GOB_PriestChamber_Belongings_Valuables' => array('WPN_Dagger_Uncommon','ARM_Ring_Uncommon'),
  'GOB_WaterfallChest' => array('ARM_Shoes_Uncommon'),
  'GOB_ZhentQuarters_Chest_Gold' => array('WPN_Longsword_Uncommon','WPN_Greatsword_Uncommon'),
  'HAG_MuderousFrog_Pouch' => array('ARM_Amulet_Uncommon'),
  'MOO_KethericCombat_Chest' => array('WPN_Shortsword_Rare','ARM_Leather_Body_Rare','ARM_Gloves_Leather_Uncommon','ARM_Boots_Leather_Uncommon'),
  'MOO_StudyReward_Chest' => array('ARM_Ring_Uncommon'),
  'PLA_AncientHarper_Melee' => array('WPN_Scimitar_Uncommon'),
  'SCL_Distillery_BrewerRoseStash_Additional' => array('ARM_Robe_Body_Uncommon','ARM_Padded_Body_Uncommon'),
  'SCL_MasonGuild_Chest' => array('WPN_Rapier_Rare'),
  'SCL_MorgueHidden_Chest' => array('ARM_Amulet_Uncommon','ARM_Ring_Uncommon'),
  'SCL_TollHouseCollectorRichChest_Treasure' => array('ARM_Ring_Uncommon_Rare'),
  'SHA_LastJusticiar_Treasure' => array('WPN_Dagger_Rare'),
  'SHA_Necromancer' => array('ARM_Amulet_Rare'),
  'TUT_Chest_Potions' => array('ARM_Shoes_Uncommon','ARM_Ring_Uncommon'),
  'TWN_Brewer_Treasure' => array('ARM_Monk_Rare','ARM_Shoes_Uncommon'),
  'TWN_Surgeon_Treasure' => array('WPN_Dagger_Rare'),
  'TWN_TollCollector_Treasure' => array('ARM_Amulet_Uncommon','ARM_Ring_Uncommon'),
  'UND_DrowResupply_Chest' => array('WPN_Rapier_Uncommon','ARM_Leather_Body_Uncommon','ARM_Cloak_Uncommon'),
  'UND_KC_AdamantineGolem' => array('WPN_Longsword_Rare'),
  'UND_KC_HiddenStash' => array('ARM_Ring_Uncommon'),
  'UND_KuoToa_MushroomChest' => array('ARM_Cloak_Uncommon'),
  'UND_PetrifiedDrow_Drow_Commander' => array('ARM_StuddedLeather_Body_Rare'),
  'UND_SeluneOutpost_Paladin_Treasure' => array('WPN_Greatsword_Rare'),
  'UND_SocietyOfBrilliance_Chest' => array('ARM_Amulet_Uncommon','ARM_Ring_Uncommon','ARM_Cloak_Uncommon'),
  'UND_Tower_SecretCellar_RewardChest' => array('ARM_Robe_Body_Uncommon','ARM_Padded_Body_Uncommon'),
  'LOW_CazadorsPalace_Crypt_Treasure' => array('ARM_Cloak_VeryRare'),
  'LOW_CazadorsPlace_Treasure' => array('ARM_Robe_Body_VeryRare'),
  'LOW_DeathKnight_Elite_Treasure' => array('WPN_Greatsword_VeryRare'),
  'LOW_Grotto_Viconia' => array('WPN_Shortsword_VeryRare','ARM_Leather_Body_Rare','ARM_Gloves_Leather_Uncommon','ARM_Boots_Leather_Uncommon'),
  'LOW_Sarevok_Treasure' => array('WPN_Longsword_Rare'),
  'LOW_SorcerousSundries_MystraVault_Treasure' => array('ARM_Amulet_Rare','ARM_Ring_Rare','ARM_Cloak_Rare','ARM_Cloak_VeryRare'),
  'LOW_Undercity_Ambush_Treasure' => array('ARM_Monk_Rare','ARM_Shoes_Rare'),
  'WYR_WyrmsCastle_Banites_OpulentChest' => array('WPN_Scimitar_VeryRare','WPN_Shortsword_Uncommon','WPN_Longsword_Rare','ARM_Robe_Body_Rare','ARM_ElvenChain_Rare','ARM_Circlet_Rare','ARM_Shoes_Uncommon','ARM_Cloak_Uncommon')
);

function getRandomModifier($min, $max) {
    return rand($min, $max);
}

function getRandomPassive($table) {
  switch ($table) {
    case 'Uncommon':
      $passives = ['ARM_Ambusher_1_Passive','ARM_Elegant_1_Passive','ARM_Balance_1_Passive','ARM_BodyAid_1_Passive','ARM_Stealthy_1_Passive','EQ_ARM_GUIDANCE','EQ_ARM_Long_Jump','EQ_ARM_Blade_Ward','EQ_ARM_Feather_Fall','EQ_ARM_AttackAdvantage','EQ_ARM_Eilistraees_Burden'];
      break;
    case 'Rare':
      $passives = ['ARM_Ambusher_2_Passive','ARM_Elegant_2_Passive','ARM_Balance_2_Passive','ARM_BodyAid_2_Passive','ARM_Stealthy_2_Passive','EQ_ARM_Bless','EQ_ARM_FREEDOM_OF_MOVEMENT','EQ_ARM_GUIDANCE','EQ_ARM_Long_Jump','EQ_ARM_Beacon_Of_Hope','EQ_ARM_Blade_Ward','EQ_ARM_Feather_Fall','EQ_ARM_AttackAdvantage','EQ_ARM_Eilistraees_Burden'];
      break;
    case 'VeryRare':
      $passives = ['EQ_ARM_Ambusher_Passive','EQ_ARM_Elegant_3_Passive','EQ_ARM_Balance_3_Passive','EQ_ARM_BodyAid_3_Passive','EQ_ARM_Stealthy_3_Passive','EQ_ARM_Haste','EQ_ARM_Bless','EQ_ARM_FREEDOM_OF_MOVEMENT','EQ_ARM_Blur','EQ_ARM_See_Invisibility','MAG_AdditionalSpellSlot_Level3_Passive'];
    case 'Legendary':
      $passives = ['EQ_ARM_Ambusher_Passive','EQ_ARM_Elegant_3_Passive','EQ_ARM_Balance_3_Passive','EQ_ARM_BodyAid_3_Passive','EQ_ARM_Stealthy_3_Passive','EQ_ARM_Haste','EQ_ARM_FREEDOM_OF_MOVEMENT','EQ_ARM_Blur','EQ_ARM_See_Invisibility','EQ_ARM_STONESKIN','EQ_ARM_CRYSTALSKIN','MAG_AdditionalSpellSlot_Level3_Passive','MAG_ProtectionFromMelee_Passive'];
      break;
  }
  return $passives[array_rand($passives)];
}

function getRandomEntry(&$usedAbilities, &$usedSkills, $minMod, $maxMod, $usedResistant, $usedAdvantage, $usedAbilitiesAdv, $usedSkillsAdv, $usedAbilitiesSav) {
    $types = ['Ability','Skill','Skill'];

    $type = $types[array_rand($types)];

    switch ($type) {
        case 'Ability':
            global $abilities;
            $available = array_diff($abilities, $usedAbilities);
            if (empty($available)) return '';
            $name = $available[array_rand($available)];
            $usedAbilities[] = $name;
            if ($minMod > 1) {
              switch (getRandomModifier($maxMod, 4)) {
                  case '4':
                    return "Ability(".$name."," . getRandomModifier($minMod, $maxMod) . ");".getBonusEntry($name, $usedResistant, $usedAdvantage).";";
                  default:
                    return "Ability(".$name."," . getRandomModifier($minMod, $maxMod) . ")";
              }
            } else {
              return "Ability(".$name."," . getRandomModifier($minMod, $maxMod) . ")";
            }
        case 'Skill':
            global $skills;
            $available = array_diff($skills, $usedSkills);
            if (empty($available)) return '';
            $name = $available[array_rand($available)];
            $usedSkills[] = $name;
            if ($minMod > 1) {
              switch (getRandomModifier($maxMod, 4)) {
                  case '4':
                    return "Skill(".$name."," . getRandomModifier($minMod, $maxMod) . ");".getBonusEntry($name, $usedResistant, $usedAdvantage).";";
                  default:
                    return "Skill(".$name."," . getRandomModifier($minMod, $maxMod) . ")";
              }
            } else {
              return "Skill(".$name."," . getRandomModifier($minMod, $maxMod) . ")";
            }
    }
    return '';
}

function getBonusEntry($nameAbl, $usedResistant, $usedAdvantage) {
    $types = ['Resistance','Resistance','Advantage'];
    $type = $types[array_rand($types)];
    switch ($type) {
        case 'Resistance':
            global $resistant;
            $available = array_diff($resistant, $usedResistant);
            if (empty($available)) return '';
            $name = $available[array_rand($available)];
            $usedResistant[] = $name;
            return "Resistance(".$name.", Resistant)";
        case 'Advantage':
            global $advantage;
            $available = array_diff($advantage, $usedAdvantage);
            if (empty($available)) return '';
            $name = $available[array_rand($available)];
            $usedAdvantage[] = $name;
            switch ($name) {
              case 'Ability':
                return "Advantage(".$name.",".$nameAbl.")";
              case 'Skill':
                return "Advantage(".$name.",".$nameAbl.")";
              case 'SavingThrow':
                return "Advantage(".$name.",".$nameAbl.")";
            }
    }
    return '';
}

function randomEnchantment($minMod,$maxMod) {
  return "WeaponEnchantment(" . getRandomModifier($minMod, $maxMod) . ");WeaponProperty(Magical)";
}

function randomArmorClass($minMod,$maxMod) {
  return getRandomModifier($minMod, $maxMod);
}

function generate($numLines = 1, $numEntriesPerLine = 3, $minMod = 1, $maxMod = 5) {
    $output = "";
    for ($i = 0; $i < $numLines; $i++) {
        $entries = [];
        $usedAbilities = [];
        $usedSkills = [];
        $usedResistant = [];
        $usedAdvantage = [];
        $usedAbilitiesAdv = [];
        $usedSkillsAdv = [];
        $usedAbilitiesSav = [];

        for ($j = 0; $j < $numEntriesPerLine; $j++) {
            $entry = getRandomEntry($usedAbilities, $usedSkills, $minMod, $maxMod, $usedResistant, $usedAdvantage, $usedAbilitiesAdv, $usedSkillsAdv, $usedAbilitiesSav);
            if ($entry !== '') {
                $entries[] = $entry;
            }
        }
        $output .= implode(';', $entries);
    }
    return $output;
}

function getUUID($type) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/uuidcontentuidgen/".$type);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function getLSX() {
  $lsx_template = '<?xml version="1.0" encoding="utf-8"?>
<save>
  <version major="4" minor="0" revision="9" build="0" lslib_meta="v1,bswap_guids,lsf_adjacency" />
  <region id="Templates">
    <node id="Templates">
      <children>
        <node id="GameObjects">
          <attribute id="Description" type="TranslatedString" handle="{{CONTENTDESC}}" version="1" />
          <attribute id="DisplayName" type="TranslatedString" handle="{{CONTENTNAME}}" version="1" />
          <attribute id="Stats" type="FixedString" value="{{STATSNAME}}" />
          <attribute id="MapKey" type="FixedString" value="{{UUID}}" />
          <attribute id="Name" type="LSString" value="{{STATSNAME}}" />
          <attribute id="Icon" type="FixedString" value="{{ICONNAME}}" />
          <attribute id="ParentTemplateId" type="FixedString" value="{{PARENT}}" />
          <attribute id="PhysicsTemplate" type="FixedString" value="{{PHYSICS}}" />
          <attribute id="VisualTemplate" type="FixedString" value="{{VISUAL}}" />
          <attribute id="LevelName" type="FixedString" value="" />
          <attribute id="Type" type="FixedString" value="item" />
          <attribute id="_OriginalFileVersion_" type="int64" value="144115205255725059" />
        </node>
      </children>
    </node>
  </region>
</save>';
  return $lsx_template;
}

function getWPNARM() {
  $WPNARM_template = 'new entry "{{STATSNAME}}"
type "{{TYPE}}"
using "{{Using}}"
data "RootTemplate" "{{UUID}}"
';
  return $WPNARM_template;
}

# Parse CSV
$filename = $argv[1];
$data = [];

if (($handle = fopen($filename, 'r')) !== false) {
    $headers = fgetcsv($handle);
    while (($row = fgetcsv($handle)) !== false) {
        $data[] = array_combine($headers, $row);
    }
    fclose($handle);
}

foreach ($data as $item) {
  $render = true;
  $lsx_template = getLSX();
  $WPNARM_template = getWPNARM();
  $type = explode('_', $item['Using'])[0];
  switch ($type) {
    case 'WPN':
      $item['TYPE'] = "Weapon";
      break;
    case 'ARM':
      $item['TYPE'] = "Armor";
      break;
  }

  $item['UUID']=getUUID('UUID');
  $item['CONTENTNAME']=getUUID('ContentUID');
  $item['CONTENTDESC']=getUUID('ContentUID');
  $item['STATSNAME']=$item['Using']."_".preg_replace('/ /','_',preg_replace("/'/","",preg_replace('/’/','',preg_replace('/"/','',$item['Name']))));
  $config_slug = $item['Using']."_".$item['Config'];

  switch($config_slug) {
    case 'WPN_Dagger_Hum0':
      $item['ICONNAME']="Item_WPN_HUM_Dagger_A_0";
      $item['PARENT']="569b0f3d-abcd-4b01-aaf0-979091288163";
      $item['PHYSICS']="56184af3-63ea-442e-b111-fe81bff2c2f4";
      $item['VISUAL']="564ac843-ea39-4fd9-b9ee-b37cee7e6734";
    break;
    case 'WPN_Dagger_Hum1':
      $item['ICONNAME']="Item_WPN_HUM_Dagger_A_1";
      $item['PARENT']="569b0f3d-abcd-4b01-aaf0-979091288163";
      $item['PHYSICS']="56184af3-63ea-442e-b111-fe81bff2c2f4";
      $item['VISUAL']="d8750051-1a68-8141-c24c-2036ec8cb7e5";
    break;
    case 'WPN_Dagger_Hum2':
      $item['ICONNAME']="Item_WPN_HUM_Dagger_A_2";
      $item['PARENT']="569b0f3d-abcd-4b01-aaf0-979091288163";
      $item['PHYSICS']="56184af3-63ea-442e-b111-fe81bff2c2f4";
      $item['VISUAL']="98ddc4a9-d74b-46d0-c714-3e4e1c3650f9";
    break;
    case 'WPN_Dagger_Drow':
      $item['ICONNAME']="Item_WPN_DROW_Dagger_Dolor_A";
      $item['PARENT']="e8df5166-5a68-42ec-b71f-4dfb754f7aa4";
      $item['PHYSICS']="b35643b5-6ecb-9477-9438-a87825a80e92";
      $item['VISUAL']="f20422c3-5ff2-0ef0-02a2-dade286845a5";
      break;
    case 'WPN_Dagger_Devi':
      $item['ICONNAME']="Item_WPN_Devils_Dagger_Levistus_A_0";
      $item['PARENT']="b66d62c4-b38f-43dd-920d-40d250d66d03";
      $item['PHYSICS']="57280399-8bd7-cfe7-8ad7-ea7d56a82929";
      $item['VISUAL']="4e464b21-489a-74d3-a2b8-6c993813a375";
    break;
    case 'WPN_Dagger_Shar':
      $item['ICONNAME']="Item_WPN_Dagger_Shar";
      $item['PARENT']="258ce9f3-3f32-4546-ae6e-196b3e8e91b5";
      $item['PHYSICS']="76fd694e-35c8-9109-0d8c-78bf8e107c76";
      $item['VISUAL']="cb8ea426-fecc-de0f-ffb2-be1596ae68c0";
    break;
    case 'WPN_Rapier_Hum0':
      $item['ICONNAME']="Item_WPN_HUM_Rapier_A_0";
      $item['PARENT']="6ccc6f4d-f2a7-4e38-a96d-c3fec92fc2de";
      $item['PHYSICS']="867843bd-2188-1292-1bb6-d5ad6c5374d9";
      $item['VISUAL']="98cfbc55-27b7-baca-fa67-b2af3ffb824b";
    break;
    case 'WPN_Rapier_Hum1':
      $item['ICONNAME']="Item_WPN_HUM_Rapier_A_1";
      $item['PARENT']="705662e8-2a7f-4c7e-b0a0-e505395a45e3";
      $item['PHYSICS']="c8a89cc2-7213-40d6-f0a0-c0a9d7a26de1";
      $item['VISUAL']="d88ec5c6-e76e-c73c-8260-936ab342b1dd";
    break;
    case 'WPN_Rapier_Hum2':
      $item['ICONNAME']="Item_WPN_HUM_Rapier_A_2";
      $item['PARENT']="5c572e8e-8693-48cf-b494-2df0341f7ced";
      $item['PHYSICS']="f71a9045-983a-d528-2970-18b6c647e00b";
      $item['VISUAL']="c73e3532-d9f1-6543-fa4e-2e57db45ed9b";
    break;
    case 'WPN_Scimitar_Flam':
      $item['ICONNAME']="Item_UNI_WPN_HUM_Scimitar_FlameBlade";
      $item['PARENT']="dfb5a6ef-baee-4c0e-9b9d-7f5bd9458131";
      $item['PHYSICS']="669a850a-bc5d-3b65-3a05-ffd59a669aa8";
      $item['VISUAL']="62decd30-fd97-d7ff-e7af-5251a091da12";
    break;
    case 'WPN_Scimitar_Jinn':
      $item['ICONNAME']="Item_WPN_Djinni_Scimitar_A";
      $item['PARENT']="1576903a-cb77-4a05-be24-1714d8c61e34";
      $item['PHYSICS']="fcb1bf2e-16e2-0cb3-c82e-300a4fa316f9";
      $item['VISUAL']="73b649c5-3c6c-3b17-0853-a917484b9afd";
    break;
    case 'WPN_Scimitar_Hum0':
      $item['ICONNAME']="Item_WPN_HUM_Scimitar_A_0";
      $item['PARENT']="868217db-9dcb-414c-bb88-e321ab3e0349";
      $item['PHYSICS']="01cd461d-8bf6-cbfc-8ef5-2000a9d91e3f";
      $item['VISUAL']="2980f3d2-483b-f595-f466-a10cd26d555d";
    break;
    case 'WPN_Scimitar_Hum1':
      $item['ICONNAME']="Item_WPN_HUM_Scimitar_A_1";
      $item['PARENT']="7cc7a0e1-d0b8-4569-afb2-d538e8941894";
      $item['PHYSICS']="669a850a-bc5d-3b65-3a05-ffd59a669aa8";
      $item['VISUAL']="8d794390-7322-229f-714e-2630f5827b7f";
    break;
    case 'WPN_Scimitar_Hum2':
      $item['ICONNAME']="Item_WPN_HUM_Scimitar_A_2";
      $item['PARENT']="5193af64-48c1-406f-90bf-87f7f01b4684";
      $item['PHYSICS']="b0622531-7b66-4e7c-0f80-4a282d8693d3";
      $item['VISUAL']="26931062-ac78-ded7-8bd2-6417ef9dc4af";
    break;
    case 'WPN_Shortsword_Gith':
      $item['ICONNAME']="Item_WPN_GTY_Shortsword_A";
      $item['PARENT']="4b54911a-a32d-48ad-8691-ff28801e1275";
      $item['PHYSICS']="d0ca9f95-fb6d-9972-b966-16ac2d2b2d06";
      $item['VISUAL']="31d8308d-ee9b-8d4a-2196-79c42107e796";
    break;
    case 'WPN_Shortsword_Glow':
      $item['ICONNAME']="Item_WPN_GTY_Shortsword_A_GLOW";
      $item['PARENT']="4b54911a-a32d-48ad-8691-ff28801e1275";
      $item['PHYSICS']="d0ca9f95-fb6d-9972-b966-16ac2d2b2d06";
      $item['VISUAL']="31d8308d-ee9b-8d4a-2196-79c42107e796";
    break;
    case 'WPN_Shortsword_GIDP':
      $item['ICONNAME']="Item_WPN_GTY_Shortsword_A_LowHP_IncreasedDamagePsychic";
      $item['PARENT']="4b54911a-a32d-48ad-8691-ff28801e1275";
      $item['PHYSICS']="d0ca9f95-fb6d-9972-b966-16ac2d2b2d06";
      $item['VISUAL']="31d8308d-ee9b-8d4a-2196-79c42107e796";
    break;
    case 'WPN_Shortsword_Hum0':
      $item['ICONNAME']="Item_WPN_HUM_Shortsword_A_0";
      $item['PARENT']="467ddb4f-6791-41fa-99f7-ee8620d63bbe";
      $item['PHYSICS']="4ccc1aaa-179c-3503-e8e7-9689107ddb04";
      $item['VISUAL']="f93bc0ca-6b76-11ac-0de3-4142dfc8f48e";
    break;
    case 'WPN_Shortsword_Hum1':
      $item['ICONNAME']="Item_WPN_HUM_Shortsword_A_1";
      $item['PARENT']="261b946f-154b-4f75-8985-cab6531034a2";
      $item['PHYSICS']="3ff6c1b6-56b8-1db7-5b5f-e19da23d4c84";
      $item['VISUAL']="9fecddcb-0f52-f5f7-cce9-7c7442704866";
    break;
    case 'WPN_Shortsword_Hum2':
      $item['ICONNAME']="Item_WPN_HUM_Shortsword_A_2";
      $item['PARENT']="0839fb15-24ab-4c3a-b168-413a47ed710a";
      $item['PHYSICS']="64a51858-bc1f-d499-fba8-f5232571d7c6";
      $item['VISUAL']="6008d69a-f868-4ff5-376a-8a2be68d3d20";
    break;
    case 'WPN_Shortsword_Moon':
      $item['ICONNAME']="Item_WPN_HUM_Moonblade_A";
      $item['PARENT']="0a6f620d-32f4-499a-9c11-db105441a57a";
      $item['PHYSICS']="39a955c8-3039-cf14-0a7e-a3e15d62a0cf";
      $item['VISUAL']="00c3c1d9-c723-c8c9-9251-97d6dda9e700";
    break;
    case 'WPN_Longsword_Gith':
      $item['ICONNAME']="Item_WPN_GTY_Longsword_A_GLOW";
      $item['PARENT']="907a794b-b089-406b-880d-6f2df2bb3f13";
      $item['PHYSICS']="c7c67380-25fe-6814-78fa-2ed1cb511dab";
      $item['VISUAL']="0771b2c1-ff5a-267b-5b94-95d39ba134c3";
    break;
    case 'WPN_Longsword_Glow':
      $item['ICONNAME']="Item_WPN_GTY_Longsword_A_GLOW";
      $item['PARENT']="907a794b-b089-406b-880d-6f2df2bb3f13";
      $item['PHYSICS']="c7c67380-25fe-6814-78fa-2ed1cb511dab";
      $item['VISUAL']="0771b2c1-ff5a-267b-5b94-95d39ba134c3";
    break;
    case 'WPN_Longsword_GIDP':
      $item['ICONNAME']="Item_WPN_GTY_Longsword_A_LowHP_IncreasedDamagePsychic";
      $item['PARENT']="907a794b-b089-406b-880d-6f2df2bb3f13";
      $item['PHYSICS']="c7c67380-25fe-6814-78fa-2ed1cb511dab";
      $item['VISUAL']="0771b2c1-ff5a-267b-5b94-95d39ba134c3";
    break;
    case 'WPN_Longsword_Hum0':
      $item['ICONNAME']="Item_WPN_HUM_Longsword_A_0";
      $item['PARENT']="1865323f-b428-4791-a0a9-578841e57463";
      $item['PHYSICS']="0671a245-3533-6589-a71b-e5948c9c6826";
      $item['VISUAL']="c1319fce-3d47-ac75-e502-a3e965500038";
    break;
    case 'WPN_Longsword_Hum1':
      $item['ICONNAME']="Item_WPN_HUM_Longsword_A_1";
      $item['PARENT']="3fc2ba50-3070-4caa-abe8-3bf885969bde";
      $item['PHYSICS']="cd4a8a69-8f43-bfe1-5998-5831c52ffd19";
      $item['VISUAL']="91a755e7-f02c-19cd-8d61-3da7192a8396";
    break;
    case 'WPN_Longsword_Hum2':
      $item['ICONNAME']="Item_WPN_HUM_Longsword_A_2";
      $item['PARENT']="e3b2adb6-7493-466e-9c65-4281fb74e83f";
      $item['PHYSICS']="04e52de8-3bc3-5321-ddf4-bd6863ab80e9";
      $item['VISUAL']="910f74da-8b12-9762-1e97-f6f3457d80de";
    break;
    case 'WPN_Longsword_Adam':
      $item['ICONNAME']="Item_WPN_HUM_Longsword_Adamantine_A";
      $item['PARENT']="d116f35c-4399-408c-ba90-b455a5d29a1f";
      $item['PHYSICS']="cd4a8a69-8f43-bfe1-5998-5831c52ffd19";
      $item['VISUAL']="56d90029-423f-e537-a8e2-bcc797d7cdc7";
    break;
    case 'WPN_Longsword_Dead':
      $item['ICONNAME']="Item_WPN_HUM_Longsword_Deathknight";
      $item['PARENT']="0a11f6f4-5605-4dff-a3e6-b172e4dba555";
      $item['PHYSICS']="0671a245-3533-6589-a71b-e5948c9c6826";
      $item['VISUAL']="82a5ea8b-b67e-2575-b708-6b878e1650e4";
    break;
    case 'WPN_Longsword_Good':
      $item['ICONNAME']="WPN_HUM_Longsword_GuardianOfFaith_Good";
      $item['PARENT']="dd0e60fd-a334-411b-97cf-fa6a015c578b";
      $item['PHYSICS']="04e52de8-3bc3-5321-ddf4-bd6863ab80e9";
      $item['VISUAL']="8a32ccbc-31b9-0623-079f-4b252e26409e";
    break;
    case 'WPN_Longsword_Evil':
      $item['ICONNAME']="Item_WPN_HUM_Longsword_GuardianOfFaith_Evil";
      $item['PARENT']="083ddacf-e03c-4681-887b-80dee8158b26";
      $item['PHYSICS']="04e52de8-3bc3-5321-ddf4-bd6863ab80e9";
      $item['VISUAL']="8a32ccbc-31b9-0623-079f-4b252e26409e";
    break;
    case 'WPN_Greatsword_Gith':
      $item['ICONNAME']="Item_WPN_GTY_Greatsword_A";
      $item['PARENT']="d1082e88-b1e2-479d-913f-1413784d95a1";
      $item['PHYSICS']="e2ba2c2b-5ec8-daf3-1e34-b2b583552b8d";
      $item['VISUAL']="b9790200-7f39-4c03-a86b-d452187c1add";
    break;
    case 'WPN_Greatsword_Glow':
      $item['ICONNAME']="Item_WPN_GTY_Greatsword_A_GLOW";
      $item['PARENT']="d1082e88-b1e2-479d-913f-1413784d95a1";
      $item['PHYSICS']="e2ba2c2b-5ec8-daf3-1e34-b2b583552b8d";
      $item['VISUAL']="b9790200-7f39-4c03-a86b-d452187c1add";
    break;
    case 'WPN_Greatsword_GIDP':
      $item['ICONNAME']="Item_WPN_GTY_Greatsword_A_LowHP_IncreasedDamagePsychic";
      $item['PARENT']="d1082e88-b1e2-479d-913f-1413784d95a1";
      $item['PHYSICS']="e2ba2c2b-5ec8-daf3-1e34-b2b583552b8d";
      $item['VISUAL']="b9790200-7f39-4c03-a86b-d452187c1add";
    break;
    case 'WPN_Greatsword_Hum0':
      $item['ICONNAME']="Item_WPN_HUM_Greatsword_A_0";
      $item['PARENT']="2798c9f8-b06b-44d4-9d6c-e6d982c502fa";
      $item['PHYSICS']="928451e2-5f3a-6d4c-8e9b-182ce189114b";
      $item['VISUAL']="037c06e4-86e9-6a94-93b2-0bdccd467356";
    break;
    case 'WPN_Greatsword_Hum1':
      $item['ICONNAME']="Item_WPN_HUM_Greatsword_A_0";
      $item['PARENT']="1a2a58b7-4bd5-44d5-b1fe-8cd7e5b53def";
      $item['PHYSICS']="928451e2-5f3a-6d4c-8e9b-182ce189114b";
      $item['VISUAL']="037c06e4-86e9-6a94-93b2-0bdccd467356";
    break;
    case 'WPN_Greatsword_Hum2':
      $item['ICONNAME']="Item_WPN_HUM_Greatsword_A_2";
      $item['PARENT']="2741505a-9d0b-4c9e-adcd-2e6339491e95";
      $item['PHYSICS']="f7a9b81c-f4b5-fe8d-e13c-c39665436596";
      $item['VISUAL']="3f21a54d-9731-6b12-4bde-430be278c9dd";
    break;
    case 'WPN_Greatsword_Hub0':
      $item['ICONNAME']="Item_WPN_HUM_Greatsword_B_0";
      $item['PARENT']="5e8597e6-7695-4333-8895-1ffe7a47db1d";
      $item['PHYSICS']="73ab32d7-1b55-036b-3e82-c20857259006";
      $item['VISUAL']="06341da6-60ae-3ca0-2986-13a2dcd73f73";
    break;
    case 'WPN_Greatsword_Hub1':
      $item['ICONNAME']="Item_WPN_HUM_Greatsword_B_1";
      $item['PARENT']="81a83529-5bb6-4c72-b1af-6fc8f45c5706";
      $item['PHYSICS']="6ec34d6f-a904-0a28-33e7-ad5c8cb4fa5a";
      $item['VISUAL']="421b7547-1981-8a88-e706-8bb4e956c568";
    break;
    case 'ARM_Robe_Body_Mag1':
      $item['ICONNAME']="Generated_ARM_Cloth_A_1_Magic";
      $item['PARENT']="427d12a3-dff2-4b59-978e-8e55daaed4ce";
      $item['PHYSICS']="c02733f7-992e-6e54-52c3-592af751b1a6";
      $item['VISUAL']="0d2daba6-a1fc-2d32-8f59-40b2a2c6c516";
    break;
    case 'ARM_Robe_Body_Mag2':
      $item['ICONNAME']="Generated_ARM_Cloth_A_2_Magic";
      $item['PARENT']="0f2e59b9-c244-4e3c-836e-4f1e7b755b12";
      $item['PHYSICS']="c02733f7-992e-6e54-52c3-592af751b1a6";
      $item['VISUAL']="0d2daba6-a1fc-2d32-8f59-40b2a2c6c516";
    break;
    case 'ARM_Robe_Body_B1':
      $item['ICONNAME']="Item_ARM_Cloth_B_1";
      $item['PARENT']="e52d44c-ecda-4dcb-aefa-058e5df0d849";
      $item['PHYSICS']="5f57d1d8-256f-66c3-c242-e71fcfd803f1";
      $item['VISUAL']="e90a01fe-f187-f592-93d3-02549c8e24af";
    break;
    case 'ARM_Robe_Body_B2':
      $item['ICONNAME']="Item_ARM_Cloth_B_2";
      $item['PARENT']="11efdb40-8246-4707-b40c-1e57635dfbc1";
      $item['PHYSICS']="5f57d1d8-256f-66c3-c242-e71fcfd803f1";
      $item['VISUAL']="9f57541a-2db4-8e16-7b3b-621e81dcd6c0";
    break;
    case 'ARM_Robe_Body_E':
      $item['ICONNAME']="Generated_ARM_Robe_E";
      $item['PARENT']="a2221f54-df0d-4129-aef2-6a2f8113ffe3";
      $item['PHYSICS']="391cbca0-5115-e291-8161-63de82a64f15";
      $item['VISUAL']="49611b19-3b49-0e9d-e9ae-abb2d8a2d8e4";
    break;
    case 'ARM_Robe_Body_2':
      $item['ICONNAME']="Item_ARM_Robe_2";
      $item['PARENT']="7ec40cde-4d96-4352-b93e-cdcab6383337";
      $item['PHYSICS']="205d2bc1-a8cf-b5f8-6e51-f53869bcfb99";
      $item['VISUAL']="47471e6f-0055-5232-091e-40224e86eedd";
    break;
    case 'ARM_Robe_Body_B2':
      $item['ICONNAME']="Item_ARM_Robe_B_2";
      $item['PARENT']="467cca20-42bb-45cd-8eac-6ed49bbc2707";
      $item['PHYSICS']="205d2bc1-a8cf-b5f8-6e51-f53869bcfb99";
      $item['VISUAL']="47471e6f-0055-5232-091e-40224e86eedd";
    break;
    case 'ARM_Robe_Body_Bard':
      $item['ICONNAME']="Item_ARM_Robe_Bard_A";
      $item['PARENT']="da345d08-2186-4e4a-857c-3fd6a104cec6";
      $item['PHYSICS']="4b41b623-431f-56ac-f251-18f16a9a614d";
      $item['VISUAL']="0d1223c9-86f0-876e-8fb0-b2717838a9b0";
    break;
    case 'ARM_Robe_Body_B':
      $item['ICONNAME']="Item_ARM_Robe_B";
      $item['PARENT']="69302808-57a0-4fbb-9938-137bce5421d1";
      $item['PHYSICS']="55f51913-5383-d402-d81d-4d179c66eb55";
      $item['VISUAL']="47471e6f-0055-5232-091e-40224e86eedd";
    break;
    case 'ARM_Robe_Body_D':
      $item['ICONNAME']="Item_ARM_Robe_D";
      $item['PARENT']="e18ee5a2-485a-42d4-8d64-e5497b4b96c7";
      $item['PHYSICS']="391cbca0-5115-e291-8161-63de82a64f15";
      $item['VISUAL']="8c8e5c5c-a9bc-f2ec-ba02-0d68cb777041";
    break;
    case 'ARM_Robe_Body_Base':
      $item['ICONNAME']="Item_ARM_Robe";
      $item['PARENT']="168b9099-19f5-44e4-b55c-e64ceb60b71f";
      $item['PHYSICS']="55f51913-5383-d402-d81d-4d179c66eb54";
      $item['VISUAL']="16a6dbf2-888c-a986-ad5c-49e5d861f76c";
    break;
    case 'ARM_Robe_Body_Sorc':
      $item['ICONNAME']="Item_ARM_Robe_Sorcerer";
      $item['PARENT']="37be86c0-f4af-48af-86c9-e91c57ce04bc";
      $item['PHYSICS']="55f51913-5383-d402-d81d-4d179c66eb54";
      $item['VISUAL']="464e8fd3-3a49-3c47-7027-fc1aef4be362";
    break;
    case 'ARM_Padded_Body_2B':
      $item['ICONNAME']="Item_ARM_Padded_2_B";
      $item['PARENT']="fc721f60-be51-4903-b5cf-79e43bf0343c";
      $item['PHYSICS']="60559836-7278-46b6-e2e2-40fb4f00ed6c";
      $item['VISUAL']="da7cec42-c73a-66b4-ff68-5c5f0c84f0b2";
    break;
    case 'ARM_Padded_Body_2':
      $item['ICONNAME']="Item_ARM_Padded_2";
      $item['PARENT']="96613037-cbac-4f43-a39b-584e6f2629c7";
      $item['PHYSICS']="60559836-7278-46b6-e2e2-40fb4f00ed6c";
      $item['VISUAL']="da7cec42-c73a-66b4-ff68-5c5f0c84f0b2";
    break;
    case 'ARM_Padded_Body_3':
      $item['ICONNAME']="Item_ARM_Padded_3";
      $item['PARENT']="63cc7723-245d-4b62-b9e6-5a47283cf777";
      $item['PHYSICS']="60559836-7278-46b6-e2e2-40fb4f00ed6c";
      $item['VISUAL']="a5067421-f96f-1147-dde6-c0484c8990fd";
    break;
    case 'ARM_Padded_Body_4':
      $item['ICONNAME']="Item_ARM_Padded_4";
      $item['PARENT']="f5faa6c5-a43c-4edd-a77f-6e7536a7e683";
      $item['PHYSICS']="55f51913-5383-d402-d81d-4d179c66eb54";
      $item['VISUAL']="d0a96f4f-a2ba-76d0-3271-2b14444e8372";
    break;
    case 'ARM_Leather_Body_2':
      $item['ICONNAME']="Item_ARM_Leather_2";
      $item['PARENT']="ac71c753-c207-465c-b28b-c10f95ed0745";
      $item['PHYSICS']="25f3ab03-a693-b347-07c8-6e7a0b29efb9";
      $item['VISUAL']="b7b5ed84-7ecf-b93c-7772-4dfd8aefe56d";
    break;
    case 'ARM_Leather_Body_3':
      $item['ICONNAME']="Item_ARM_Leather_3";
      $item['PARENT']="02ae5d88-8044-43df-8363-02a2900776db";
      $item['PHYSICS']="25f3ab03-a693-b347-07c8-6e7a0b29efb9";
      $item['VISUAL']="34224022-5848-75f4-28c2-89994c3218e3";
    break;
    case 'ARM_Leather_Body_4':
      $item['ICONNAME']="Item_ARM_Leather_4";
      $item['PARENT']="90a79e46-e327-41f4-a349-8e4dd70b1892";
      $item['PHYSICS']="25f3ab03-a693-b347-07c8-6e7a0b29efb9";
      $item['VISUAL']="114e3d10-8b95-196e-6927-53ccef20c11d";
    break;
    case 'ARM_Leather_Body_Drow':
      $item['ICONNAME']="Item_ARM_Leather_Drow";
      $item['PARENT']="181383f0-c2db-4a15-9786-7d5a396dbfdd";
      $item['PHYSICS']="25f3ab03-a693-b347-07c8-6e7a0b29efb9";
      $item['VISUAL']="b81997b7-91ee-3c84-5ff4-e0abf8919d9a";
    break;
    case 'ARM_Leather_Body_DruM':
      $item['ICONNAME']="Generated_MAG_Druid_Magic_Leather_Armor_Magic";
      $item['PARENT']="10338c7e-39c8-44b3-a0a2-2a76af453718";
      $item['PHYSICS']="a255f5d8-7ac8-7f40-74d0-3a97cd4abc8f";
      $item['VISUAL']="4ca00d0c-4279-24cd-58dc-7c20dec761db";
    break;
    case 'ARM_Leather_Body_DruA':
      $item['ICONNAME']="Item_ARM_Leather_Druid_A";
      $item['PARENT']="b8468a39-a5ff-4de0-85be-a8883a479628";
      $item['PHYSICS']="4b41b623-431f-56ac-f251-18f16a9a614d";
      $item['VISUAL']="06b13dc8-907e-aacf-8d86-32b42acf94f8";
    break;
    case 'ARM_StuddedLeather_Body_Mag2':
      $item['ICONNAME']="Generated_ARM_StuddedLeather_2_Magic";
      $item['PARENT']="83603f36-d158-4a0e-b9c9-358413ba3a92";
      $item['PHYSICS']="004e659d-8256-376a-2079-decbad9c71ee";
      $item['VISUAL']="5d8a3615-2040-d19d-bcf2-b28dc8c7b419";
    break;
    case 'ARM_StuddedLeather_Body_1':
      $item['ICONNAME']="Item_ARM_StuddedLeather_1";
      $item['PARENT']="58d7927f-c6eb-4635-85b6-70265c621b3d";
      $item['PHYSICS']="004e659d-8256-376a-2079-decbad9c71ee";
      $item['VISUAL']="5d8a3615-2040-d19d-bcf2-b28dc8c7b419";
    break;
    case 'ARM_StuddedLeather_Body_Dro2':
      $item['ICONNAME']="Item_ARM_StuddedLeather_Drow_2";
      $item['PARENT']="cab3455f-59fe-42be-8dcd-7cd61149389a";
      $item['PHYSICS']="004e659d-8256-376a-2079-decbad9c71ee";
      $item['VISUAL']="5792b6ab-628b-e1cf-4c37-34c3124f5d5e";
    break;
    case 'ARM_StuddedLeather_Body_Drow':
      $item['ICONNAME']="Item_ARM_StuddedLeather_Drow";
      $item['PARENT']="431f019e-3706-4a23-af48-e29acbc0e43b";
      $item['PHYSICS']="004e659d-8256-376a-2079-decbad9c71ee";
      $item['VISUAL']="5792b6ab-628b-e1cf-4c37-34c3124f5d5e";
    break;
    case 'ARM_StuddedLeather_Body_Dro1':
      $item['ICONNAME']="Item_ARM_StuddedLeather_Drow_Magic";
      $item['PARENT']="3ce4d5d2-3ed0-470e-8cea-bdac81a60583";
      $item['PHYSICS']="004e659d-8256-376a-2079-decbad9c71ee";
      $item['VISUAL']="5792b6ab-628b-e1cf-4c37-34c3124f5d5e";
    break;
    case 'ARM_ElvenChain_Elf':
      $item['ICONNAME']="Generated_MAG_PHB_ElvenChain_Armor_Magic";
      $item['PARENT']="391bccb7-8199-41e3-9aa3-261def2ebf26";
      $item['PHYSICS']="576d3a67-0602-d215-df08-bca3dff41007";
      $item['VISUAL']="ac0b0670-d6e9-c806-4b77-2e4cb8599a5e";
    break;
    case 'ARM_Monk_A2':
      $item['ICONNAME']="Generated_ARM_Gloves_Cloth_A_2_Magic";
      $item['PARENT']="4d8f4081-d0ed-4649-b2d3-974706a3e102";
      $item['PHYSICS']="e0e99996-ea3c-019f-c5c6-aa691874f6d0";
      $item['VISUAL']="5f62a315-7a4b-3c99-e1d9-8188b56cd918";
    break;
    case 'ARM_Monk_Miss':
      $item['ICONNAME']="Generated_UNI_ARM_OfMissileSnaring_Gloves_Magic";
      $item['PARENT']="687cc55b-77a3-4893-a7d7-cfbafdc2737c";
      $item['PHYSICS']="d57abb81-7bd6-41dd-b5bd-cf4fbcd33576";
      $item['VISUAL']="7a20e13c-9838-aece-1099-c2bfa804150a";
    break;
    case 'ARM_Gloves_Leather_Miss':
      $item['ICONNAME']="Generated_UNI_ARM_OfMissileSnaring_Gloves_Magic";
      $item['PARENT']="687cc55b-77a3-4893-a7d7-cfbafdc2737c";
      $item['PHYSICS']="d57abb81-7bd6-41dd-b5bd-cf4fbcd33576";
      $item['VISUAL']="7a20e13c-9838-aece-1099-c2bfa804150a";
    break;
    case 'ARM_Gloves_Leather_Drow':
      $item['ICONNAME']="Item_ARM_Gloves_Leather_Drow";
      $item['PARENT']="f740cc6f-c7dd-4c31-8dbd-04138f59801e";
      $item['PHYSICS']="d57abb81-7bd6-41dd-b5bd-cf4fbcd33576";
      $item['VISUAL']="f034a35c-39ce-126f-0b65-cd8d0ea57daf";
    break;
    case 'ARM_Gloves_Leather_E':
      $item['ICONNAME']="Item_ARM_Gloves_Leather_E";
      $item['PARENT']="540d6714-c030-4fd5-83e0-592a0f443d70";
      $item['PHYSICS']="d57abb81-7bd6-41dd-b5bd-cf4fbcd33576";
      $item['VISUAL']="e6663e65-8da7-c0e1-dbeb-3dfcf9d0f0e7";
    break;
    case 'ARM_Gloves_Leather_F':
      $item['ICONNAME']="ARM_Gloves_Leather_F";
      $item['PARENT']="1dc6610c-0dbf-4b5a-b671-2af3a7c80a8e";
      $item['PHYSICS']="d57abb81-7bd6-41dd-b5bd-cf4fbcd33576";
      $item['VISUAL']="827413ce-dc79-80da-46fe-2864b17e5f75";
    break;
    case 'ARM_Monk_Monk':
      $item['ICONNAME']="Item_ARM_Gloves_Monk";
      $item['PARENT']="d06d06dc-0aa6-407e-b4b4-3225978be1c7";
      $item['PHYSICS']="2bed84c1-4574-06cc-c2a0-03bda2284e1f";
      $item['VISUAL']="b44f2874-99eb-0e7a-c3c9-e9014b2294a8";
    break;
    case 'ARM_Circlet_Mag1':
      $item['ICONNAME']="Generated_ARM_Headwear_Cloth_A_1_Magic";
      $item['PARENT']="06270b96-794d-4e01-ab90-835888df526f";
      $item['PHYSICS']="1e5caa93-d952-a848-fcd7-e6204f12859b";
      $item['VISUAL']="d6185afe-0e71-9944-c009-9b091937c30b";
    break;
    case 'ARM_Circlet_Mag2':
      $item['ICONNAME']="Generated_ARM_Headwear_Cloth_A_2_Magic";
      $item['PARENT']="529be51a-a2ba-4354-afeb-0b533a194917";
      $item['PHYSICS']="2f2ad33d-7818-720d-e794-0b1808f7b7a4";
      $item['VISUAL']="388d9eca-e37c-60a9-60b9-7045e644e03f";
    break;
    case 'ARM_Circlet_Bla':
      $item['ICONNAME']="Item_ARM_CircletOfBlasting";
      $item['PARENT']="3abdbb8a-4701-4397-8fce-7a8dd8a0bb84";
      $item['PHYSICS']="8542a974-9aa8-8b2b-21c7-395dfd7b96be";
      $item['VISUAL']="21f8ec11-2ecf-73e8-123b-a5da10ebd800";
    break;
    case 'ARM_Circlet_Int':
      $item['ICONNAME']="Item_ARM_HeadbandOfIntellect";
      $item['PARENT']="8779b30f-dc6f-4264-b7af-9dc0eff51bb0";
      $item['PHYSICS']="2e1a42e4-0d6a-afd1-adbb-5c978f90ce58";
      $item['VISUAL']="21f8ec11-2ecf-73e8-123b-a5da10ebd800";
    break;
    case 'ARM_Circlet_Gith':
      $item['ICONNAME']="Item_ARM_Headwear_Circlet_Githyanki_A";
      $item['PARENT']="5b2412a1-b8e2-4c09-a5ca-50c5103fd297";
      $item['PHYSICS']="48529758-120a-ec00-f515-bc3730dd4813";
      $item['VISUAL']="a88025fb-c1d1-5393-2ab7-971f144093ec";
    break;
    case 'ARM_Circlet_Iso':
      $item['ICONNAME']="Item_ARM_Headwear_Circlet_Isobele_A";
      $item['PARENT']="0eadc734-3ffd-4a87-9185-54e3e4cbacbf";
      $item['PHYSICS']="02b3b387-eb7e-33f5-b7dc-33c5ebba23fe";
      $item['VISUAL']="065b8db8-5a3f-eb96-46b6-1038020ede8d";
    break;
    case 'ARM_Boots_Leather_Spd':
      $item['ICONNAME']="Generated_ARM_BootsOfSpeed_Magic";
      $item['PARENT']="8b22d15a-85bb-4c8d-90cf-a773fc451eac";
      $item['PHYSICS']="8be0d494-a364-5ec6-6ee9-5ac30fa8cf49";
      $item['VISUAL']="28efb600-a2e9-3cfa-ce83-323219ed6378";
    break;
    case 'ARM_Boots_Leather_Mag1':
      $item['ICONNAME']="Item_ARM_Boots_Leather_1";
      $item['PARENT']="2b02fa12-7f83-4fd1-a3d6-43230b829ec3";
      $item['PHYSICS']="8be0d494-a364-5ec6-6ee9-5ac30fa8cf49";
      $item['VISUAL']="3c26cca7-14fe-a8a4-e358-84fa08fe0aeb";
    break;
    case 'ARM_Boots_Leather_Drow':
      $item['ICONNAME']="Item_ARM_Boots_Leather_Drow";
      $item['PARENT']="cda7838e-f619-4eea-913c-817ae3f2df09";
      $item['PHYSICS']="a4c77b5e-bf2f-771a-ba49-a40e3dfa1e8f";
      $item['VISUAL']="36a435f9-6228-f46d-f6bd-67bf9e68b932";
    break;
    case 'ARM_Boots_Leather_Nigh':
      $item['ICONNAME']="Item_EQ_ARM_NightWalkers_GLOW";
      $item['PARENT']="ac9145d1-31d0-4aa3-8755-62cc85dad22b";
      $item['PHYSICS']="a4c77b5e-bf2f-771a-ba49-a40e3dfa1e8f";
      $item['VISUAL']="592c055d-7e93-6b38-bfe1-40e8943a3dcb";
    break;
    case 'ARM_Shoes_E':
      $item['ICONNAME']="Item_ARM_Shoes_E_Magic";
      $item['PARENT']="c3f02e6c-d519-40d1-b686-a241a9f9972e";
      $item['PHYSICS']="6624ea7a-b46e-78fa-f3fb-c1b9794ab583";
      $item['VISUAL']="28efb600-a2e9-3cfa-ce83-323219ed6378";
    break;
    case 'ARM_Shoes_F':
      $item['ICONNAME']="Item_ARM_Shoes_F_Magic";
      $item['PARENT']="524ca019-25b5-4769-a9e4-842505710e77";
      $item['PHYSICS']="a4c77b5e-bf2f-771a-ba49-a40e3dfa1e8f";
      $item['VISUAL']="a877a6e1-6539-d4cc-34a2-53e9ae48c8e3";
    break;
    case 'ARM_Shoes_G':
      $item['ICONNAME']="Item_ARM_Shoes_G_Magic";
      $item['PARENT']="6c194c79-51c7-4cbd-a5b1-ef0d06b7c559";
      $item['PHYSICS']="a4c77b5e-bf2f-771a-ba49-a40e3dfa1e8f";
      $item['VISUAL']="7ae2c844-1269-40b3-9b1c-15b74dbe7483";
    break;
    case 'ARM_Shoes_H':
      $item['ICONNAME']="Item_ARM_Shoes_H_Magic";
      $item['PARENT']="127d5d89-d6ab-4e4a-b6fe-a3586e6d7020";
      $item['PHYSICS']="a4c77b5e-bf2f-771a-ba49-a40e3dfa1e8f";
      $item['VISUAL']="8f71850f-83eb-1068-e71d-e1710647e5ae";
    break;
    case 'ARM_Cloak_MagB':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_B_Magic";
      $item['PARENT']="8ed92d35-159c-493c-a8da-fba455f181e4";
      $item['PHYSICS']="f3110b5c-f53e-c1f0-72b1-6fdcd3c68a42";
      $item['VISUAL']="e0982a2a-910a-badd-b519-a26b87b66bdf";
    break;
    case 'ARM_Cloak_MagC1':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_C_1_Magic";
      $item['PARENT']="c2f0ea14-9384-4b5e-a0eb-81909ce72d38";
      $item['PHYSICS']="753392b7-a79e-7c88-ab4f-6e20eb2a6f28";
      $item['VISUAL']="3cda6ee8-7165-d606-8a74-a032cd461ae7";
    break;
    case 'ARM_Cloak_MagC':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_C_Magic";
      $item['PARENT']="a5f5a875-932b-44c4-8b45-88d2ed379787";
      $item['PHYSICS']="753392b7-a79e-7c88-ab4f-6e20eb2a6f28";
      $item['VISUAL']="2460d287-1640-1f53-bcc8-9998d5197fd8";
    break;
    case 'ARM_Cloak_MagD':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_D_Magic";
      $item['PARENT']="fc49414b-49d6-4f57-ae92-721d9d912d83";
      $item['PHYSICS']="753392b7-a79e-7c88-ab4f-6e20eb2a6f28";
      $item['VISUAL']="2f747db9-2e62-f095-936a-c018103145db";
    break;
    case 'ARM_Cloak_B':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_B";
      $item['PARENT']="8ed92d35-159c-493c-a8da-fba455f181e4";
      $item['PHYSICS']="f3110b5c-f53e-c1f0-72b1-6fdcd3c68a42";
      $item['VISUAL']="e0982a2a-910a-badd-b519-a26b87b66bdf";
    break;
    case 'ARM_Cloak_C1':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_C_1";
      $item['PARENT']="c2f0ea14-9384-4b5e-a0eb-81909ce72d38";
      $item['PHYSICS']="753392b7-a79e-7c88-ab4f-6e20eb2a6f28";
      $item['VISUAL']="3cda6ee8-7165-d606-8a74-a032cd461ae7";
    break;
    case 'ARM_Cloak_C':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_C";
      $item['PARENT']="a5f5a875-932b-44c4-8b45-88d2ed379787";
      $item['PHYSICS']="753392b7-a79e-7c88-ab4f-6e20eb2a6f28";
      $item['VISUAL']="2460d287-1640-1f53-bcc8-9998d5197fd8";
    break;
    case 'ARM_Cloak_D':
      $item['ICONNAME']="Generated_ARM_Cloak_Long_D";
      $item['PARENT']="fc49414b-49d6-4f57-ae92-721d9d912d83";
      $item['PHYSICS']="753392b7-a79e-7c88-ab4f-6e20eb2a6f28";
      $item['VISUAL']="2f747db9-2e62-f095-936a-c018103145db";
    break;
    case 'ARM_Ring_BA1':
      $item['ICONNAME']="Item_LOOT_GEN_Ring_B_Silver_A_1";
      $item['PARENT']="68262d1e-aa97-41c3-8daf-9910359705f9";
      $item['PHYSICS']="362b929e-842b-f295-4ff2-b9453cb6b33e";
      $item['VISUAL']="f002834d-a643-7b13-0f47-c43f662a96cc";
    break;
    case 'ARM_Ring_DA1':
      $item['ICONNAME']="Item_LOOT_GEN_Ring_D_Silver_A_1";
      $item['PARENT']="cda6f48d-9d06-45ee-80a2-055faf2b3801";
      $item['PHYSICS']="1b701c34-98a3-0e91-1e09-90b31f5c255c";
      $item['VISUAL']="ba72c4c6-c4b3-de99-3185-8fb9453aab34";
    break;
    case 'ARM_Ring_EA1':
      $item['ICONNAME']="Item_LOOT_GEN_Ring_E_Silver_A_1";
      $item['PARENT']="6147c8e3-6a8d-451c-9d2f-c7e13f1c4938";
      $item['PHYSICS']="e364a86e-4b28-4b62-a031-3a8e2ff3770b";
      $item['VISUAL']="cd6440cd-c97b-463e-9323-b7c3b71c9a5d";
    break;
    case 'ARM_Ring_FA1':
      $item['ICONNAME']="Item_LOOT_GEN_Ring_F_Silver_A_1";
      $item['PARENT']="9f12dae8-3291-4969-a044-e53ffaac5937";
      $item['PHYSICS']="150c8eed-748f-978f-a2c6-d58dee1ab158";
      $item['VISUAL']="f109d7d8-861b-465f-6cd7-55d35040b04a";
    break;
    case 'ARM_Ring_HA1':
      $item['ICONNAME']="Item_LOOT_GEN_Ring_H_Silver_A_1";
      $item['PARENT']="3324ec12-1c95-4eef-ac0d-99375a5ff88e";
      $item['PHYSICS']="b36cb83e-0859-e8c3-3439-17f5d1732792";
      $item['VISUAL']="4aa98ff1-b8f0-9b2c-39b9-5e499082c806";
    break;
    case 'ARM_Ring_IA1':
      $item['ICONNAME']="Item_LOOT_GEN_Ring_I_Silver_A_1";
      $item['PARENT']="f56496ba-a50e-49b9-8697-778160376416";
      $item['PHYSICS']="a66957f1-6a2a-cc1c-13eb-5a19690469f1";
      $item['VISUAL']="8a3db3d1-ad87-8ac9-71a6-4f53bb0a4bfd";
    break;
    case 'ARM_Amulet_AA1':
      $item['ICONNAME']="Item_LOOT_GEN_Amulet_Necklace_A_Silver_A_1";
      $item['PARENT']="d6b70158-3493-4c76-9f8d-e410e2e36cec";
      $item['PHYSICS']="b4572f2e-08c0-1ecc-2f60-ff5207f6111d";
      $item['VISUAL']="c8b72a5f-ee93-6689-3cd5-1408f1741d75";
    break;
    case 'ARM_Amulet_BA1':
      $item['ICONNAME']="Item_LOOT_GEN_Amulet_Necklace_B_Silver_A_1";
      $item['PARENT']="a117bf60-4623-485d-8fd8-a2d2273fea00";
      $item['PHYSICS']="d75d3546-087c-0026-969d-0edbe022fae3";
      $item['VISUAL']="f2366fad-c8fa-39ae-6c05-0df580ac804d";
    break;
    case 'ARM_Amulet_CA1':
      $item['ICONNAME']="Item_LOOT_GEN_Amulet_Necklace_C_Silver_A_1";
      $item['PARENT']="20612f0e-2dae-45c1-8398-94840a6af489";
      $item['PHYSICS']="8edfe18e-36b7-d706-9e9e-9dcf56dc4331";
      $item['VISUAL']="4c1ef917-d5a4-3484-69ea-588e3e208012";
    break;
    case 'ARM_Amulet_FA1':
      $item['ICONNAME']="Item_LOOT_GEN_Amulet_Necklace_F_Silver_A_1";
      $item['PARENT']="f2f3d3a1-459f-483e-85d9-3170ffd71e93";
      $item['PHYSICS']="a186b331-0ef6-6857-c2f9-557e5ab987cb";
      $item['VISUAL']="1643c8e3-3819-6612-e089-03ae1f03338f";
    break;
    case 'ARM_Instrument_FluteE':
      $item['ICONNAME']="Item_TOOL_GEN_Music_Flute_A";
      $item['PARENT']="848ad8dc-59f3-464b-b8b2-95eab6022446";
      $item['PHYSICS']="a77e159b-e71e-be55-f103-f8737f745ff8";
      $item['VISUAL']="3925e752-71e1-d24b-feed-e4c8d6579b80";
    break;
    case 'ARM_Instrument_LuteE':
      $item['ICONNAME']="Item_TOOL_GEN_Music_Guitar_Lute_A";
      $item['PARENT']="8f98a7e7-c773-4b58-9127-5cf79b9206e9";
      $item['PHYSICS']="5d5007e5-cb6f-30ad-3d20-f762ea437673";
      $item['VISUAL']="4d6be548-8175-a052-d9cd-b8845eb826f0";
    break;
    case 'ARM_Instrument_LyreE':
      $item['ICONNAME']="Item_TOOL_GEN_Music_Lyre_A";
      $item['PARENT']="13739f15-7366-4d7f-9926-991e98b9e964";
      $item['PHYSICS']="f0acac13-2e32-c047-378e-4087af902d05";
      $item['VISUAL']="7fccc115-7155-af61-ad8f-0f27e2f92644";
    break;
    default:
      print_r("Item Config Does Not Exist\n");
      print_r($item);
      $render = false;
    break;
  }
  if ($render) {
    foreach ($item as $key => $value) {
      $lsx_template = str_replace('{{' . $key . '}}', $value, $lsx_template);
      $WPNARM_template = str_replace('{{' . $key . '}}', $value, $WPNARM_template);
    }

    if (!empty($item['Boosts'])) {
      if (preg_match('/generate/',$item['Boosts'])) {
        $args = explode(',',preg_replace('/generate:/','',$item['Boosts']));
        $WPNARM_template.="data \"Boosts\" \"".generate('1',$args[0],$args[1],$args[2])."\"\n";
      } else {
        $WPNARM_template.="data \"Boosts\" \"".$item['Boosts']."\"\n";
      }
    }
    if (!empty($item['DefaultBoosts'])) {
      if (preg_match('/randomEnchantment/',$item['DefaultBoosts'])) {
        $args = explode(',',preg_replace('/randomEnchantment:/','',$item['DefaultBoosts']));
        $WPNARM_template.="data \"DefaultBoosts\" \"".randomEnchantment($args[0],$args[1])."\"\n";
      } else {
        $WPNARM_template.="data \"DefaultBoosts\" \"".$item['DefaultBoosts']."\"\n";
      }
    }
    if (!empty($item['ArmorClass'])) {
      if (preg_match('/randomArmorClass/',$item['ArmorClass'])) {
        $args = explode(',',preg_replace('/randomArmorClass:/','',$item['ArmorClass']));
        $WPNARM_template.="data \"ArmorClass\" \"".randomArmorClass($args[0],$args[1])."\"\n";
      } else {
        $WPNARM_template.="data \"ArmorClass\" \"".$item['ArmorClass']."\"\n";
      }
    }
    if (!empty($item['PassivesOnEquip'])) {
      if (preg_match('/getRandomPassive/',$item['PassivesOnEquip'])) {
        $args = explode(',',preg_replace('/getRandomPassive:/','',$item['PassivesOnEquip']));
        $WPNARM_template.="data \"PassivesOnEquip\" \"".getRandomPassive($args[0])."\"\n";
      } else {
        $WPNARM_template.="data \"PassivesOnEquip\" \"".$item['PassivesOnEquip']."\"\n";
      }
    }
    $stats_array=array("BoostsOnEquipMainHand","BoostsOnEquipOffHand","Damage","Damage Type","PassivesMainHand","PassivesOffHand","PersonalStatusImmunities","Rarity","StatusInInventory","StatusOnEquip","ValueUUID","ValueLevel","WeaponFunctors","Weapon Properties");
    foreach ($stats_array as $data) {
      if (!empty($item[$data])) {
        $WPNARM_template.="data \"".$data."\" \"".$item[$data]."\"\n";
      }
    }
    $content_file .= '  <content contentuid="'.$item['CONTENTNAME'].'" version="1">'.$item['Name'].'</content>'."\n";
    $content_file .= '  <content contentuid="'.$item['CONTENTDESC'].'" version="1">'.$item['Description'].'</content>'."\n";
    file_put_contents('MyMods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/RootTemplates/'.$item['UUID'].'.lsx',$lsx_template);
    $current = file_get_contents('MyMods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Stats/Generated/Data/'.$item['TYPE'].'.txt');
    $current .= "\n";
    $current .= $WPNARM_template;
    file_put_contents('MyMods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Stats/Generated/Data/'.$item['TYPE'].'.txt',$current);
    if (!isset($using_last) || $using_last != $item['Using'].'_'.$item['Rarity']) {
      $using_last=$item['Using'].'_'.$item['Rarity'];
      $treasure_tables[$item['Using']][] = $item['Rarity'];
      $treasure_table .= 'new treasuretable "Eilistraean_'.$item['Using'].'_'.$item['Rarity'].'"'."\n";
      $treasure_table .= 'new subtable "1,1"'."\n";
    }
    $treasure_table .= 'object category "I_'.$item['STATSNAME'].'",1,0,0,0,0,0,0,0'."\n";
  }
}
$content_file .= "</contentList>\n";
file_put_contents('MyMods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Mods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Localization/English/english.xml', $content_file);
$treasure = file_get_contents('MyMods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Stats/Generated/TreasureTable.txt');
$treasure .= "\n";
$treasure .= $treasure_table;
foreach ($treasure_tables as $key => $value) {
  $treasure .= 'new treasuretable "Eilistraean_'.$key.'"'."\n";
  foreach ($value as $rarity) {
    $treasure .= 'new subtable "1,1"'."\n";
    switch ($rarity) {
      case 'Uncommon':
        $treasure .= 'StartLevel "2"'."\n";
        $treasure .= 'EndLevel "4"'."\n";
        break;
      case 'Rare':
        $treasure .= 'StartLevel "5"'."\n";
        $treasure .= 'EndLevel "7"'."\n";
        break;
      case 'VeryRare':
        $treasure .= 'StartLevel "8"'."\n";
        break;
      case 'Legendary':
        $treasure .= 'StartLevel "10"'."\n";
        break;
    }
    $treasure .= 'object category "T_Eilistraean_'.$key.'_'.$rarity.'",1,0,0,0,0,0,0,0'."\n";
  }
}
foreach ($treasure_tables_to_tables as $key => $value) {
  $treasure .= 'new treasuretable "'.$key.'"'."\n";
  $treasure .= 'CanMerge 1'."\n";
  foreach($value as $itemset) {
    $treasure .= 'new subtable "1,1"'."\n";
    $treasure .= 'object category "T_Eilistraean_'.$itemset.'",1,0,0,0,0,0,0,0'."\n";
  }
}
foreach ($treasure_tables_to_drops as $key => $value) {
  $treasure .= 'new treasuretable "'.$key.'"'."\n";
  $treasure .= 'CanMerge 1'."\n";
  foreach($value as $itemset) {
    $treasure .= 'new subtable "1,1"'."\n";
    $treasure .= 'object category "T_Eilistraean_'.$itemset.'",1,0,0,0,0,0,0,0'."\n";
  }
}
file_put_contents('MyMods/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Public/church_of_Eilistraee-fa53e39c-706f-4a0d-b73a-9e909a095a8b/Stats/Generated/TreasureTable.txt',$treasure);
?>
