%ники игроков
player(zywOo).
player(sh1ro).
player(niKo).
player(blameF).
player(frozen).
player(s1mple).
player(m0NESY).
player(ax1Le).
player(ropz).
player(sunPayus).

%названия команд
team(vitality).
team(cloud9).
team(g2).
team(astralis).
team(navi).

%типы оружий
gun(awp).
gun(rifle).

%названия турниров
tournament(gamers8).
tournament(parisMajor).
tournament(brazyParty).
tournament(cologne).
tournament(katowice).

%указание команды игрокам, в которой они играют
player_in_team(zywOo,vitality).
player_in_team(sh1ro,cloud9).
player_in_team(niKo,g2).
player_in_team(blameF,astralis).
player_in_team(s1mple,navi).
player_in_team(m0NESY,g2).
player_in_team(ax1Le,cloud9).

%присвоение оружия игрокам, с которым играют
player_gun(zywOo,awp).
player_gun(sh1ro,awp).
player_gun(niKo,rifle).
player_gun(blameF,rifle).
player_gun(frozen,rifle).
player_gun(s1mple,awp).
player_gun(m0NESY,awp).
player_gun(ax1Le,rifle).
player_gun(ropz,rifle).
player_gun(sunPayus,rifle).

%возраст игроков
player_age(zywOo,21).
player_age(sh1ro,22).
player_age(niKo,23).
player_age(blameF,24).
player_age(frozen,21).
player_age(s1mple,24).
player_age(m0NESY,19).
player_age(ax1Le,22).
player_age(ropz,23).
player_age(sunPayus,20).

%Турниры, которые выиграли игроки
player_won_tournament(zywOo,gamers8).
player_won_tournament(zywOo,parisMajor).
player_won_tournament(sh1ro,brazyParty).
player_won_tournament(ax1Le,brazyParty).
player_won_tournament(niKo,cologne).
player_won_tournament(niKo,katowice).

%Уровень игры команды
team_level(vitality,1).
team_level(cloud9,2).
team_level(g2,1).
team_level(astralis,3).
team_level(navi,2).

%Определение команды выигравшей турнир, по ее игроку
team_won_tournament(Team,Tournament) :- player_in_team(Player,Team),player_won_tournament(Player,Tournament).

%Определение игроков в одной команде
players_in_team(Player1,Player2,Team) :- player_in_team(Player1,Team),player_in_team(Player2,Team),not(Player1==Player2).

%Проверка есть ли в команде игрок с таким оружием
team_has_gun(Team,Gun) :- player_in_team(Player,Team),player_gun(Player,Gun).

%Определение игроков с одинаковым оружием
players_guns(Player1,Player2,Gun) :- player_gun(Player1,Gun),player_gun(Player2,Gun),not(Player1==Player2).

%Отсутствие оружия в команде
team_has_not_gun(Team, Gun) :- team(Team),not(team_has_gun(Team, Gun)).