import json

confirmedGuests = {
    "response": []
}
errorGuests = {
    "response": []
}

with open("1.Guest.Original.json") as json_file:
    data = json.load(json_file)
    counter = 0
    emailsCorrectos = 0
    for response in data:
        responseId  = response["Response ID"]
        attendance  = response["Q1"]
        email       = response["Q2"].lower()
        employee    = response["Q3"]
        
        if attendance == "si":
            counter += 1
            name = email.split("@")[0]
            ticketDict = {
                    "id": employee,
                    "name": name,
                    "arrived": "0",
                    "email": email,
                }
            if "@oracle.com" in email:
                emailsCorrectos += 1
                confirmedGuests["response"].append(ticketDict)
                if ticketDict["id"] == "":
                    ticketDict["id"] = name
                    
            else:
                errorGuests["response"].append(ticketDict)
                print("Email incorrecto: " + email)

    print("Asistentes = " + str(counter))
    print("Emails correctos = " + str(emailsCorrectos))

    with open('errorGuests.json', 'w', encoding='utf-8') as errorFile:
        json.dump(errorGuests, errorFile, ensure_ascii=False, indent=4)
    
    with open('confirmedGuests.json', 'w', encoding='utf-8') as confirmedFile:
        json.dump(confirmedGuests, confirmedFile, ensure_ascii=False, indent=4)

   # print("Guests amenos = " + str(errorGuests))