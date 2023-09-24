"""Модуль производит обработку запроса с предпочтениями для поиска наилучшего варианта команды или игрока"""
import prolog


def handleRequest(string: list):
    """Функция обрабатывет запрос

    string - список со строкой запроса, разбитой на подзапросы"""

    # Рельтирующая выборка элементов исходя из запроса
    answer = {}

    def addToAnswer(items: list):
        """Функция обрабатывает результаты подзапроса, ведя рейтинг в выборке

            items - результаты полученные из БЗ текущим подзапросом"""
        for name in items:
            if name not in answer:
                answer[name] = 0
            answer[name] += 1

    requests = 0

    if string[0].lower() == 'игрок':

        # Ограничение поворяющихся запросов
        possible_requests = {
            "age": 0,
            "ageAbove": 0,
            "ageLower": 0,
            "no-team": 0,
            "teams": [],
            "teammates": [],
            "guns": [],
            "tournaments": []
        }

        for i in range(1, len(string)):
            parameter = string[i].split()
            if len(parameter) <= 1 or len(parameter) > 3:
                print("Ошибка в параметре", i)
                continue
            players = []
            match parameter[0].lower():
                case 'возраст':
                    try:
                        if parameter[1].lower() == 'меньше':
                            if possible_requests["ageLower"] == 1:
                                continue
                            players = prolog.getPlayersAgeLower(int(parameter[2]))
                            possible_requests["ageLower"] = 1
                        elif parameter[1].lower() == 'больше':
                            if possible_requests["ageAbove"] == 1:
                                continue
                            players = prolog.getPlayersAgeAbove(int(parameter[2]))
                            possible_requests["ageAbove"] = 1
                        else:
                            if possible_requests["age"] == 1:
                                continue
                            players = prolog.getPlayersByAge(int(parameter[1]))
                            possible_requests["age"] = 1
                    except ValueError:
                        print("Значение должно быть числом:", parameter[1])
                        continue
                case 'команда':
                    if parameter[1].lower() == "нет":
                        if possible_requests["no-team"] == 1:
                            continue
                        players = prolog.getPlayersWithoutTeam()
                        possible_requests["no-team"] = 1
                    else:
                        if parameter[1].lower() in possible_requests["teams"]:
                            continue
                        possible_requests["teams"].append(parameter[1].lower())
                        players = prolog.getPlayersWithTeam(parameter[1].lower())
                case 'оружие':
                    if parameter[1].lower() in possible_requests["guns"]:
                        continue
                    possible_requests["guns"].append(parameter[1].lower())
                    players = prolog.getPlayersWithGun(parameter[1].lower())
                case 'турнир':
                    if parameter[1].lower() in possible_requests["tournaments"]:
                        continue
                    possible_requests["tournaments"].append(parameter[1].lower())
                    players = prolog.getPlayersWonTournament(parameter[1].lower())
                case 'сокомандник':
                    if parameter[1].lower() in possible_requests["teammates"]:
                        continue
                    possible_requests["teammates"].append(parameter[1].lower())
                    players = prolog.getPlayersTogether(parameter[1].lower())
                case _:
                    print("Ошибка в параметре", i, parameter[0])
            addToAnswer(players)
        if len(answer) > 0:
            print("Выборка игроков на основе ваших предпочтений:")
            for req in possible_requests:
                if possible_requests[req]:
                    requests += 1
        else:
            print("Не удалось подобрать игроков по вашим параметрам.")
    elif string[0].lower() == 'команда':
        # Ограничение поворяющихся запросов
        possible_requests = {
            "age": 0,
            "isGun": 0,
            "noGun": 0,
            "teammates": [],
            "levels": [],
            "tournaments": []
        }
        for i in range(1, len(string)):
            parameter = string[i].split()
            if len(parameter) <= 1 or len(parameter) > 3:
                print("Ошибка в параметре", i)
                continue
            teams = []
            match parameter[0].lower():
                case 'уровень':
                    if parameter[1].lower() in possible_requests["levels"]:
                        continue
                    try:
                        teams = prolog.getTeamsByLevel(int(parameter[1]))
                        possible_requests["levels"].append(int(parameter[1]))
                    except ValueError:
                        print("Значение должно быть числом:", parameter[1])
                        continue
                case 'турнир':
                    if parameter[1].lower() in possible_requests["tournaments"]:
                        continue
                    possible_requests["tournaments"].append(parameter[1].lower())
                    teams = prolog.getTeamsWonTournament(parameter[1].lower())
                case 'напарник':
                    if parameter[1].lower() in possible_requests["teammates"]:
                        continue
                    possible_requests["teammates"].append(parameter[1].lower())
                    teams = prolog.getTeamWithPlayer(parameter[1].lower())
                case 'имеется':
                    if possible_requests["isGun"] == 1:
                        continue
                    teams = prolog.getTeamsWithGun(parameter[1].lower())
                    possible_requests["isGun"] = 1
                case 'использую':
                    if possible_requests["noGun"] == 1:
                        continue
                    teams = prolog.getTeamsWithoutGun(parameter[1].lower())
                    possible_requests["noGun"] = 1
                case 'возраст':
                    if possible_requests["age"] == 1:
                        continue
                    teams = prolog.getTeamsWithAgeAbove(parameter[1].lower())
                    possible_requests["age"] = 1
                case _:
                    print("Ошибка в параметре", i, parameter[0])
            addToAnswer(teams)
        if len(answer) > 0:
            print("Выборка команд, подходящих вам:")
            for req in possible_requests:
                if possible_requests[req]:
                    requests += 1
        else:
            print("Не удалось подобрать команды по вашим параметрам.")
    else:
        print('Некорректные значения в запросе: ', string[0])

    # Сортировка элементов по их рейтингу в подзапросах
    answer = dict(sorted(answer.items(), key=lambda item: item[1], reverse=True))

    best = 0
    for key in answer:
        if answer[key] == requests:
            best = requests
        elif best == 0:
            best = answer[key]
    if best != requests:
        print("Не удалось получить результат, удовлетворяющий всем параметрам. Представлены наиболее подходящие варианты.")

    for key in answer:
        if answer[key] == best:
            print(key)
