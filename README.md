



Coding Challenge

A server side application that exposes an API that allows me to create, modify and remove tasks.

1. To list all the tasks

This will list all the tasks which needs to be taken up for the day and for future

Endpoint: GET http://localhost/todolist/api-tasks
Basic Authentication:
username: apiuser
password: 777

Successful Response:
{
    "status": "success",
    "data": [
        {
            "id": "1",
            "task": "Wish Joey birthday",
            "due_date": "Today, 11:30 AM",
            "is_completed": "No"
        },
        {
            "id": "2",
            "task": "Talk to Client - Manchester",
            "due_date": "Tommorow, 10:30 AM",
            "is_completed": "No"
        },
        {
            "id": "3",
            "task": "Complete documentation of Char project",
            "due_date": "Wed, Mar 10, 2021, 12:30 PM",
            "is_completed": "No"
        }
    ],
    "message": "TO-DO Listing",
    "Code": 200
}

Failure Response:
{
    "status": "error",
    "message": "No Data",
    "Code": 500
}


2. To add a task

This is to add a task in the TO-DO List

Endpoint: POST http://localhost/todolist/api-addtasks
Basic Authentication:
username:apiuser
password:777
Required parameters: 'task'

Successful Case
Sample Request
{
    "task": "Call Maria",
    "due_date": "03/08/2021 12:00 AM"
}

Successful Response
{
    "status": "success",
    "message": "Task has been added successfully."
    "code": "200",
}

Failure Case
Sample Request 
{
    "task": "",
    "due_date": ""
}
Response
{
    "status": "error",
    "message": "Data not proper, you need to enter task",
    "Code": 500
}


3. To edit a task
This is to edit a task from TO-DO list.

Endpoint: PUT http://localhost/todolist/api-edittasks/{id}
Basic Authentication:
username:apiuser
password:777
Required parameters: 'task'

Successful Case
http://localhost/todolist/api-edittask/3

Sample Request
{
    "task": "Meeting with the client",
    "due_date": "03/08/2021 12:00 AM"
}

Response
{
    "status": "success",
    "message": "Task has been updated successfully"
    "Code": 200
}

Failure Case : Invalid ID
http://localhost/todolist/api-edittask/33

Sample Request
{
    "task": "Meeting with the client",
    "due_date": "03/08/2021 12:00 AM"
}

Response
{
    "status": "error",
    "message": "Data is not proper, invalid task id"
}


3. To delete a task
This is to delete a task from TO-DO list.

Endpoint: DELETE http://localhost/todolist/api-deletetask
Basic Authentication:
username:apiuser
password:777
Required parameters: 'id'

Successful Case
Sample Request
{
    "id": "8"
}

Response
{
    "status": "success",
    "message": "Task has been deleted successfully"
}

Failure Case : Invalid ID
Sample Request
{
    "id": "58"
}

Response
{
    "status": "error",
    "message": "Data is not proper, invalid task id"
}



A client side application that provides a GUI for the server side application. 

Frontend: HTML, Bootstrap, CSS, JavaScript
Backend: PHP

http://localhost/todolist

This page will list all the tasks which needs to be handle on that day (Today's task)
You can add, edit or delete any task

Upcoming Tasks: Lists the task which has future dates

Overdue Tasks: Tasks which are not completed will appear on this page and you can reschedule the task

Completed Tasks: Lists all the completed tasks.

Database: todolist_db - The database structure & data has been included in the main directory. (todolist_db.sql)


