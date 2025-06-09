#!/bin/zsh
# This script is based on Labotor's .psd helper for creating
# icons as shared on the Down by the River Discord Server. 
# Her operations, parameters and colors were my starting point
# and helped me a lot in figuring out how to do this. If you have
# access to photoshop, have a look at her work!

############################################################
# Help Texts and Processing Command Options                #
############################################################
# show help/usage -h
  show_help()
  {
    # Display Help
    echo "Usage: domagick.sh [-h] [-l] [-s style] [-t] <input filename>"
    echo 
    echo "Input should be an image file with black lines on a"
    echo "transparent background."
    echo
    echo "Options:"
    echo "-h         show this messsage"
    echo "-i         show credits"
    echo "-l         list available styles"
    echo "-s style   pick a style for your icon, default is attack"
    echo "-t         test mode, generates just a .png file instead of .DDS files"
    echo
  }
# show info/credits -i
  show_info() {
    echo "This script is based on Labotor's .psd helper for"
    echo "creating skill icons, shared on the Down by the River"
    echo "discord server."
    echo "Adaption into this script was done by pie."
  }
# show available icon styles -s
  show_styles()
  {
    echo "attack - similar to icons for many attack skills, such as the default melee and ranged attacks"
    echo "basic - similar to icons for non-attack skills, such as entering Rage"
    echo "class - similar to icons for class actions, such as Create Sorcery Points or Ki Restoration, as well as passives"
    echo "heal - similar to icons for skills that restore HP, such as Song of Rest"
    echo "monster - similar to icons for attacks from wildshaped druids or beast familiars"
    echo "spell-acid - similar to icons for acid type damage"
    echo "spell-cold - similar to icons for cold type damage"
    echo "spell-fire - similar to icons for fire type damage"
    echo "other options to be added in the future"
  }

  # set defaults:
  style="attack"
  output_only=1
# Get the options
  while getopts ":hs:t" option; do
      case $option in
          h) # display help
            show_help
            exit ;;
          i)
            show_info
            exit ;;
          l) # list available styles
            show_styles
            exit ;;
          s) # Pick a style
            style=$OPTARG ;;
          t) # turn on test mode
            output_only=0 ;;
          :) # no style provided?
            echo "-${OPTARG} requires a style to be specified, to get available styles, use domagick.sh -l"
            exit 1 ;;
          \?) # Invalid option
            echo "Error: Invalid option"
            show_help
            exit 1 ;;
      esac
  done

  # get the file name as $1
  shift "$((OPTIND-1))"

# do some input checking
  if [ $# -lt 1 ]; then
    echo "Error: no input file specified."
    exit 1
  elif [ $# -gt 1 ]; then
    echo "Error: more than 1 input file specified."
    exit 1
  elif [ ! -f "$1" ]; then
    echo "Error: input file does not exist."
    echo 1
  fi

  # input filename is probably ok to use now
  inputfile="$1"

### TODO ###
  # consider using mean/median to adjust colours some more
  # https://im.snibgo.com/setmean.htm and https://im.snibgo.com/gainbias.htm 
  # color means are listed in magick <input> -verbose info:

  # look into generating a diff version of attack for atlas icons
  # vanilla icon on atlas is way more yellow than tooltip

  # TODO: variants
  # common action/bonus action: no special effects, just outline + shadow, exaples: dash, disengage
  # spell/elemental colors:
  # Acid, Cold, Fire, Force, Lightning, Necrotic, Poison, Psychic, Radiant, Thunder
  # other color variants
  # Debuff (btw psychic and thunder), Control, Heal Spell, Green/Nature, Blood
  # MAYBE
  # white, abjuration, wild magic, conjure, extra-intense, darkvision/darkness

### NOTES ###
 # -virtual-pixel transparent
 #    used so imagemagick assumes pixels around the image are also transparent
 #    important for good blurring/morphing results

############################################################
# General Prep                                             #
############################################################
# don't want to spam my current folder with tons of images
  if [ ! -d ./temp_images ]; then   
      mkdir temp_images
  fi

# variables for readability
  input=temp_images/input.png
  output=temp_images/output.png
  stroke=temp_images/stroke.png
  t=temp_images

# if we're testing, don't put output into temp_images
  if [ $output_only -eq 0 ]; then
    output=output.png
  fi

# make sure input has the expected dimensions
  magick $inputfile -channel A -threshold 50% -resize 384x384 $input

# default colors and parameters - many get overriden below
  base_color='#d19e09'
  stroke_color='#881f18'
  
  # gradient (dissolved over image to create subtle color variations)
    gradient_dark='#a66900'
    gradient_light='#fac73b'
    # transparency is changed via dissolve parameters:
    # 0 is transparent, 100 is equal to source image
    gradient_opacity='25,100' # gradient-opacity,background-opacity

  # inner glow (screened over image to create line glow effect)
    innerglow_color='#feedb0'
    # -morphology Distance is used for getting the gradient within the lines
    innerglow_iterations='3' # number of iterations, this is slow!
    # radius determines kernel size (bigger = more exact)
    # scale determines how much distance is between darkest and brightest pixels
    innerglow_kernel='Euclidean:5,8!' # Type:radius,scale
    # using blur to reduce 'brightness steps'
    innerglow_blur='0x0.5' # radius x sigma - radius 0 means IM guesses good radius, sigma is blur amount
    # transparency is changed by multiplying alpha channel values,
    # 0 is transparent, 1 is no change, <1 is more transparency, >1 is less transparency
    innerglow_opacity='1.5'
    # flag for adding a second glow
    addglow2=0
    innerglow2_kernel='Euclidean:5,6!'
    innerglow2_blur='0x0.01'
    innerglow2_opacity='0.8'

  # outer glow (overlayed to create background glow effect)
    outerglow_color='#8f4511'
    # blur results in a denser glow effect than shadow
    outerglow_blur='0x15' # radius x sigma - radius 0 means IM guesses good radius, sigma is blur amount
    outerglow_offset='+0+0' # +x moves right, +y moves down
    # currently commented out, alternative method to using blur
    outerglow_shadow='100x15+0+0' # opacity x blursize + offset + offset
    # transparency is changed by multiplying alpha channel values,
    # 0 is transparent, 1 is no change, <1 is more transparency, >1 is less transparency
    outerglow_opacity='1'

  # shadow (put below the image to help lines stand out more)
    shadow_color='#743a00'
    shadow_shadow='80x3+4+4' # opacity x blursize + offset + offset
    # transparency is changed by multiplying alpha channel values,
    # 0 is transparent, 1 is no change, <1 is more transparency, >1 is less transparency
    shadow_opacity='1'

############################################################
# Image Editing                                            #
############################################################
  magick_attack() {
    # set colors
    base_color='#ff8d3a'
    bevel_color='#fee57d'
    stroke_color='#881f18'
    gradient_dark='#702800'
    gradient_light='#ffeea9'
    shadow_color='#301d08'
    outerglow_color='#c60200'
    innerglow_color='#f9b36f'

    # set transparency values
    innerglow_kernel='Euclidean:3,1000'
    innerglow_opacity='1'
    outerglow_blur='0x17'
    outerglow_offset='+0+5'
    outerglow_opacity='1.1'
    gradient_opacity='20,100' # first number for gradient, 100 is for background

    magick_process

    # alternate ways to color bevel:
      #magick $t/bevel.png -channel RGB -fill $bevel_color -colorize 100% $t/bevel.png
      #magick composite -colorspace RGB -compose overlay $t/bevel.png \( -size 384x384 xc:$bevel_color \) $t/bevel.png
  }

  magick_basicaction() {
    base_color='#d19e09'
    gradient_dark='#a66900'
    gradient_light='#fac73b'
    shadow_color='#743a00'
    outerglow_color='#8f4511'
    innerglow_color='#feedb0'

    # set function parameters
    innerglow_opacity='1.3'
    outerglow_offset='+5+5'
    shadow_opacity='0.7'
    gradient_opacity='33,100' 

    magick_process
  }

  magick_classaction() {
    # set colors
    base_color='#7caed1'
    gradient_dark='#23405d'
    gradient_light='#3ea7d5'
    shadow_color='#103457'
    outerglow_color='#3f6076'
    innerglow_color='#cde1ee'

    # set function parameters
    innerglow_blur='0x1.9' 
    innerglow_kernel='Euclidean:5,6!'
    outerglow_offset='+0+3'
    outerglow_opacity='1.4'

    magick_process
  }

  magick_healing() {
    # set colors
    base_color='#12b18d'
    gradient_dark='#006075'
    gradient_light='#00a480'
    shadow_color='#00623a'
    outerglow_color='#00623a'
    innerglow_color='#bcdee0'

    # set function parameters
    innerglow_opacity='1.83'
    innerglow_distance='5,6!'
    innerglow_blur='0x1.5'
    outerglow_offset='+3+3'
    shadow_opacity='0.6'

    magick_process
  }

  magick_monster() {
    # set colors
    base_color='#daa871'
    gradient_dark='#986c40'
    gradient_light='#e3b583'
    shadow_color='#6f4c2f'
    outerglow_color='#6e431a'
    innerglow_color='#e4d2bc'

    # set function parameters
    innerglow_opacity='1.3'
    innerglow_blur='0x0.5'
    # outerglow_opacity='1.2'
    outerglow_offset='+7+3' # +x moves right, +y moves down

    magick_process
  }

  magick_spell_acid() {
    # set colors
    base_color='#98a029'
    gradient_dark='#686e22'
    gradient_light='#e2ef31'
    shadow_color='#686e22'
    outerglow_color='#7f862a'
    innerglow_color='#fdff8f'
    innerglow2_color='#cfd837'


    innerglow_kernel='Euclidean:5,10!'
    innerglow_blur='0x0.1'
    innerglow_opacity='1.4'

    addglow2=1
    innerglow2_kernel='Euclidean:5,6!'
    innerglow2_blur='0x0.01'
    innerglow2_opacity='0.8'

    outerglow_blur='0x17'
    outerglow_offset='+3+3'
    outerglow_opacity='1.4'

    shadow_opacity='0.2'

    magick_process
  }

  magick_spell_cold() {
    # set colors
    base_color='#00b6dc'
    gradient_dark='#0e74bd'
    gradient_light='#1595ca'
    shadow_color='#094a82'
    outerglow_color='#138db9'
    innerglow_color='#cff8ff'
    innerglow2_color='#9cf1ff'


    innerglow_kernel='Euclidean:5,10!'
    innerglow_blur='0x0.1'
    innerglow_opacity='1.4'

    addglow2=1
    innerglow2_kernel='Euclidean:5,6!'
    innerglow2_blur='0x0.01'
    innerglow2_opacity='0.8'

    outerglow_blur='0x17'
    outerglow_offset='+3+3'
    outerglow_opacity='1.4'

    shadow_opacity='0.2'

    magick_process
  }

  magick_spell_fire() {
    # set colors
    base_color='#fc6e0a'
    gradient_dark='#fc4c0a'
    gradient_light='#feb963'
    shadow_color='#a03b1c'
    outerglow_color='#ae3e18'
    innerglow_color='#ffe4c2'
    innerglow2_color='#feb963'


    innerglow_kernel='Euclidean:5,10!'
    innerglow_blur='0x0.1'
    innerglow_opacity='1.4'

    addglow2=1
    innerglow2_kernel='Euclidean:5,6!'
    innerglow2_blur='0x0.01'
    innerglow2_opacity='0.8'

    outerglow_blur='0x17'
    outerglow_offset='+3+3'
    outerglow_opacity='1.4'

    shadow_opacity='0.2'

    magick_process
  }

# produce the result
 # magick composite {overlay} {background} [{mask}] [-compose {method}] {result}
 # magick {background} {overlay} [{mask}] [-compose {method}] -composite {result}

  magick_process() {
    # create overlay gradient
    # grayscale gradient: slow operation, so only create if it's not already here
    if [ ! -f ./temp_images/gradient_bw.png ]; then   
        magick -size 400x400 xc: -fx 'xx=i/w-.5; yy=j/h-.5; rr=xx*xx+yy*yy; 1-rr*4' \
          -gravity center -crop 384x384+0+0 temp_images/gradient_bw.png
        magick temp_images/gradient_bw.png -filter Gaussian -resize 10% \
          -define filter:sigma=2.5 -resize 384x384 temp_images/gradient_bw.png
    fi
    magick -size 11x384 gradient:$gradient_dark-$gradient_light $t/gradient.png
    magick $t/gradient_bw.png $t/gradient.png -clut $t/gradient.png

    # negate input file for easier morphology
    magick composite \( $input -channel A -negate \) \( -size 384x384 xc:white \) $t/negated.png

    # create inner glow
    magick $input -channel A -virtual-pixel transparent \
      -morphology Distance:$innerglow_iterations $innerglow_kernel -blur $innerglow_blur \
      -channel RGB -fill $innerglow_color -colorize 100% \
      -channel A -evaluate Multiply $innerglow_opacity $t/innerglow.png

    # TODO: change this into a true/false bool fire spells get a second glow layer
    if [ $addglow2 -eq 1 ];then
      echo 'creating glow 2'
      magick $input -channel A -virtual-pixel transparent \
        -morphology Distance:$innerglow_iterations $innerglow2_kernel \
        -channel RGB -fill $innerglow2_color -colorize 100% \
        -channel A -evaluate Multiply $innerglow2_opacity $t/innerglow2.png
      magick composite $t/innerglow.png $t/innerglow2.png -compose over $t/innerglow.png
      rm $t/innerglow2.png
    fi

    # create outer glow using -shadow
    # magick $input -background $outerglow_color -shadow $outerglow_shadow -crop 384x384+0+0 \
    #   -channel A -evaluate Multiply $outerglow_opacity $t/outerglow.png

    # create outer glow using -blur, need to do offset separately
    magick $input -blur $outerglow_blur -fill $outerglow_color -colorize 100% \
      -channel A -evaluate Multiply $outerglow_opacity $t/outerglow.png
    magick $t/outerglow.png -page $outerglow_offset -background none -flatten $t/outerglow.png

    # create shadow
    magick $input -background $shadow_color -shadow $shadow_shadow -crop 384x384+0+0 \
      -channel A -evaluate Multiply $shadow_opacity $t/shadow.png

    # attack only: create stroke and bevel
    if [ "$style" = "attack" ];then
      # create stroke
      magick $input -morphology dilate disk:6 -blur 0x1 -level 50x100% \
        -fill $stroke_color -colorize 100% $stroke

      # create shadow adjusted for stroke presence 
      # not ideal to do this twice (old shadow is overriden), but this might be more readable?
      magick $stroke -background $shadow_color -shadow $shadow_shadow -crop 384x384+0+0 \
        -channel A -evaluate Multiply $shadow_opacity $t/shadow.png

      # create bevel
      magick $t/negated.png -shade 219x21 -morphology Dilate Octagon $t/bevel.png
      magick $t/bevel.png \( -size 10x2 gradient:black-$bevel_color \) -interpolate Nearest -clut \
          -morphology dilate disk:3 $t/bevel.png
    fi

    # assemble the result
    if [ "$style" = "attack" ]; then 
    # attack style
      magick $input -colorspace RGB -fill $base_color -colorize 100% \
        $t/bevel.png $input -compose screen -composite \
        $t/innerglow.png -compose linear-dodge -composite \
        $t/outerglow.png -compose dstover -composite \
        $stroke -compose dstover -composite \
        $t/gradient.png $stroke -compose dissolve -define compose:args=$gradient_opacity -composite \
        $t/shadow.png -compose dstover -composite \
        $output
    else 
    # all non-attack styles
      magick $input -colorspace RGB -fill $base_color -colorize 100% \
        $t/outerglow.png -compose overlay -composite \
        $t/gradient.png $input -compose dissolve -define compose:args=$gradient_opacity -composite \
        $t/innerglow.png -compose screen -composite \
        $t/shadow.png -compose dstover -composite \
        $output
      fi
  }

# generate DDS files
  generate_dds() {
    # Tooltip: 380px, fade gradient, no background
    # create bigger gradient for less fade
    magick -size 400x400 gradient: -crop 380x380+0+0 $t/tooltip_gradient.png
    magick $output -resize 380x380 \
      \( -clone 0 -alpha extract $t/tooltip_gradient.png -compose multiply -composite \) \
      -alpha off -compose copy_opacity -composite \
      -define dds:compression=dxt5 tooltip_icon.DDS

    # UI Icon: 144px, no fade, no background
    magick $output -resize 144x144 -define dds:compression=dxt5 controllerUI_icon.DDS

    # Icon Atlas: 64px, background
    # backgrounds in: Game\Public\Game\GUI\Assets\ControllerUIIcons\icon_bg_png\
    magick $output -resize 64x64 atlas_icon_nobg.png

    # bg for atlas icon can only be guessed,
    # and only if bg folder is available
    if [ ! -d ./icon_bg_png ]; then   
      echo "to generate an atlas icon with background, put the icon_bg_png folder next to this script."
      exit 0
    fi

    case "$style" in
    attack) 
      magick composite atlas_icon_nobg.png \( icon_bg_png/weaponAction_bg.DDS -resize 64x64 \) -compose over atlas_icon_bg.png ;;
    basic)
      magick composite atlas_icon_nobg.png \( icon_bg_png/action_bg.DDS -resize 64x64 \) -compose over atlas_icon_bg.png ;;
    class) 
      magick composite atlas_icon_nobg.png \( icon_bg_png/utility_bg.DDS -resize 64x64 \) -compose over atlas_icon_bg.png ;;
    heal) 
      magick composite atlas_icon_nobg.png \( icon_bg_png/heal_bg.DDS -resize 64x64 \) -compose over atlas_icon_bg.png ;;
    monster) 
      magick composite atlas_icon_nobg.png \( icon_bg_png/action_bg.DDS -resize 64x64 \) -compose over atlas_icon_bg.png ;;
    spell-acid | spell-cold | spell-fire)
      magick composite atlas_icon_nobg.png \( icon_bg_png/spell_bg.DDS -resize 64x64 \) -compose over atlas_icon_bg.png ;;
    *) 
      echo "unknown bg style specified" ;;
    esac

  }

############################################################
# picking workflow                                         #
############################################################
  case "$style" in
    attack) 
      echo "picked style: attack"
      magick_attack ;;
    basic)
      echo "picked style: basic action"
      magick_basicaction ;;
    class) 
      echo "picked style: class action"
      magick_classaction ;;
    heal)
      echo "picked style: heal action"
      magick_healing ;;
    monster)
      echo "picked style: monster attack"
      magick_monster ;;
    spell-acid)
      echo "picked style: spell acid"
      magick_spell_acid ;;
    spell-cold)
      echo "picked style: spell cold"
      magick_spell_cold ;;
    spell-fire)
      echo "picked style: spell fire"
      magick_spell_fire ;;
    *) 
      echo "unknown style specified"
      exit 1 ;;
  esac

  # generate DDS images
  if [ $output_only -eq 1 ]; then
    generate_dds
  fi