<?php

require '../inc/config.php';

$names = ':grinning:
:grin:
:joy:
:smiley:
:smile:
:sweat_smile:
:laughing:
:innocent:
:smiling_imp:
:wink:
:blush:
:yum:
:relieved:
:heart_eyes:
:sunglasses:
:smirk:
:neutral_face:
:expressionless:
:unamused:
:sweat:
:pensive:
:confused:
:confounded:
:kissing:
:kissing_heart:
:kissing_smiling_eyes:
:kissing_closed_eyes:
:stuck_out_tongue:
:stuck_out_tongue_winking_eye:
:stuck_out_tongue_closed_eyes:
:disappointed:
:worried:
:angry:
:rage:
:cry:
:persevere:
:triumph:
:disappointed_relieved:
:frowning:
:anguished:
:fearful:
:weary:
:sleepy:
:tired_face:
:grimacing:
:sob:
:open_mouth:
:hushed:
:cold_sweat:
:scream:
:astonished:
:flushed:
:sleeping:
:dizzy_face:
:no_mouth:
:mask:
:smile_cat:
:joy_cat:
:smiley_cat:
:heart_eyes_cat:
:smirk_cat:
:kissing_cat:
:pouting_cat:
:crying_cat_face:
:scream_cat:
:slightly_frowning_face:
:slightly_smiling_face:
:upside_down_face:
:face_with_rolling_eyes:
:no_good:
:ok_woman:
:bow:
:see_no_evil:
:hear_no_evil:
:speak_no_evil:
:raising_hand:
:raised_hands:
:person_frowning:
:person_with_pouting_face:
:pray:
:rat:
:mouse2:
:ox:
:water_buffalo:
:cow2:
:tiger2:
:leopard:
:rabbit2:
:cat2:
:dragon:
:crocodile:
:whale2:
:snail:
:snake:
:racehorse:
:ram:
:goat:
:sheep:
:monkey:
:rooster:
:chicken:
:dog2:
:pig2:
:boar:
:elephant:
:octopus:
:shell:
:bug:
:ant:
:bee:
:beetle:
:fish:
:tropical_fish:
:blowfish:
:turtle:
:hatching_chick:
:baby_chick:
:hatched_chick:
:bird:
:penguin:
:koala:
:poodle:
:dromedary_camel:
:camel:
:dolphin:
:mouse:
:cow:
:tiger:
:rabbit:
:cat:
:dragon_face:
:whale:
:horse:
:monkey_face:
:dog:
:pig:
:frog:
:hamster:
:wolf:
:bear:
:panda_face:
:pig_nose:
:feet:
:chipmunk:
:eyes:
:eye:
:ear:
:nose:
:lips:
:tongue:
:point_up_2:
:point_down:
:point_left:
:point_right:
:facepunch:
:wave:
:ok_hand:
:+1:
:-1:
:clap:
:open_hands:
:crown:
:womans_hat:
:eyeglasses:
:necktie:
:shirt:
:jeans:
:dress:
:kimono:
:bikini:
:womans_clothes:
:purse:
:handbag:
:pouch:
:mans_shoe:
:athletic_shoe:
:high_heel:
:sandal:
:boot:
:footprints:
:bust_in_silhouette:
:busts_in_silhouette:
:boy:
:girl:
:man:
:woman:
:family:
:couple:
:two_men_holding_hands:
:two_women_holding_hands:
:cop:
:dancers:
:bride_with_veil:
:person_with_blond_hair:
:man_with_gua_pi_mao:
:man_with_turban:
:older_man:
:older_woman:
:baby:
:construction_worker:
:princess:
:japanese_ogre:
:japanese_goblin:
:ghost:
:angel:
:alien:
:space_invader:
:imp:
:skull:
:information_desk_person:
:guardsman:
:dancer:
:lipstick:
:nail_care:
:massage:
:haircut:
:barber:
:syringe:
:pill:
:kiss:
:love_letter:
:ring:
:gem:
:couplekiss:
:bouquet:
:couple_with_heart:
:wedding:
:heartbeat:
:broken_heart:
:two_hearts:
:sparkling_heart:
:heartpulse:
:cupid:
:blue_heart:
:green_heart:
:yellow_heart:
:purple_heart:
:gift_heart:
:revolving_hearts:
:heart_decoration:
:moneybag:
:currency_exchange:
:heavy_dollar_sign:
:credit_card:
:yen:
:dollar:
:euro:
:pound:
:money_with_wings:
:chart:
:seat:
:computer:
:briefcase:
:minidisc:
:floppy_disk:
:cd:';

header('Content-Type: text/plain');

/*foreach ($symbols as $symbol) {
	echo "$symbol\n";
}

echo "\n\n";*/

preg_match_all('/\:([^\:]+)\:/', $names, $matches, PREG_SET_ORDER);

$symbols = array_values($symbols);

echo "var shortcuts = { ";

foreach ($matches as $i => $match) {
	$name = $match[1];

	echo "'$name': '$symbols[$i]', ";
}

echo " };\n";
