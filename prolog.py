"Модуль взаимодействует с БЗ, выполняя логические запросы"
from pyswip import Prolog

prolog = Prolog()
prolog.consult("lab.pl")


def getPlayers(players_list: list):
    """Функция возвращает спискок игроков, которые были выбрани подзапросом

        players_list - список объектов, полученных в результате логического запроса"""
    players = []
    for player in players_list:
        players.append(player['Player'])
    return players


def getTeams(teams_list: list):
    """Функция возвращает спискок команд, которые были выбрани подзапросом

            players_list - список объектов, полученных в результате логического запроса"""
    teams = []
    for team in teams_list:
        teams.append(team['Team'])
    return teams


def getPlayersByAge(age: int):
    """Функция возвращает спискок игроков, у которых возраст равен заданному

            age - возраст"""
    players_list = list(prolog.query("player_age(Player,"+str(age)+")."))
    return getPlayers(players_list)


def getPlayersAgeAbove(age: int):
    """Функция возвращает спискок игроков, у которых возраст больше заданного

                age - возраст"""
    players_list = list(prolog.query("player_age(Player,Age), Age>"+str(age)+"."))
    return getPlayers(players_list)


def getPlayersAgeLower(age: int):
    """Функция возвращает спискок игроков, у которых возраст меньше заданного

                age - возраст"""
    players_list = list(prolog.query("player_age(Player,Age), Age<"+str(age)+"."))
    return getPlayers(players_list)


def getPlayersWithoutTeam():
    """Функция возвращает спискок игроков, у которых нет команды"""
    players_list = list(prolog.query("player(Player),not(player_in_team(Player,_))."))
    return getPlayers(players_list)


def getPlayersWithTeam(team: str):
    """Функция возвращает спискок игроков, которые играют в заданной команде

                team - название команды"""
    players_list = list(prolog.query("player_in_team(Player,"+team+")."))
    return getPlayers(players_list)


def getPlayersWithGun(gun: str):
    """Функция возвращает спискок игроков, которые играют c заданным оружием

                   gun - тип оружия"""
    players_list = list(prolog.query("player_gun(Player,"+gun+")."))
    return getPlayers(players_list)


def getPlayersWonTournament(tournament: str):
    """Функция возвращает спискок игроков, которые выиграли заданный турнир

                   tournament - название команды"""
    players_list = list(prolog.query("player_won_tournament(Player,"+tournament+")."))
    return getPlayers(players_list)


def getPlayersTogether(teammate: str):
    """Функция возвращает спискок игроков, которые играют в команде с игроком

                   teammate - ник игрока"""
    players_list = list(prolog.query("players_in_team(Player1,"+teammate+",Team)."))
    return getPlayers(players_list)


def getTeamsByLevel(level: int):
    """Функция возвращает спискок команд, уровень которых равен заданному

                   level - уровень игры команды (1 - наивысшый)"""
    teams_list = list(prolog.query("team_level(Team," + str(level) + ")."))
    return getTeams(teams_list)


def getTeamsWonTournament(tournament: str):
    """Функция возвращает спискок команд, которые выиграли заданный турнир

                   tournament - название турнира"""
    teams_list = list(prolog.query("team_won_tournament(Team," + tournament + ")."))
    return getTeams(teams_list)


def getTeamWithPlayer(player: str):
    """Функция возвращает спискок команд, в которых играет игрок

                   player - ник игрока"""
    teams_list = list(prolog.query("player_in_team(" + player + ", Team)."))
    return getTeams(teams_list)


def getTeamsWithGun(gun: str):
    """Функция возвращает спискок команд, в которых играет игрок с таким оружием

                   gun - тип оружия"""
    teams_list = list(prolog.query("team_has_gun(Team," + gun + ")."))
    return getTeams(teams_list)


def getTeamsWithoutGun(gun: str):
    """Функция возвращает спискок команд, в которых не играет игрок с таким оружием

                   gun - тип оружия"""
    teams_list = list(prolog.query("team_has_not_gun(Team," + gun + ")."))
    return getTeams(teams_list)


