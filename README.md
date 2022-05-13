Remarks about AuthController

Create User:
    Responses (create_user):
        - the errors specific to the fields of a trainee or a coach don't appear in the errors array when there are errors in the fields of user.
        - there will always be a success field.
        -success = false ====> user was not created.
        -success = true ====> user was created.
        - whenever success = false there will be a (errors) array in the response.
        - on one occasion errors will not be an array it will be a string with the error message ('User could not be created due to internal error.') and that will happen when an internal Database error occurs(Unlikely) but it should be coded into the frontend.
        - image = false means there was problem with image but the user was created.
        - image = true means the image was saved successfuly.
    Validation(create_user):
        User Validation:
            - the FirstName LastName must be at least 3 characters and without any special characters or numbers.
            - the username must be at least 3 characters(all special characters are allowed).
            - the password must have at least 8 characters one uppercase letter and one number.
            - encoded image is not required but must be base64.   
            - gender must be in Male/Female.
            - type must be in trainee/coach.
        Trainee Validation:
            - DOB must be a date.
            - initial plan must be in muscle,weight,height,stretching.
            - week_start must be in monday,tuesday,wednesday,thursday,friday,saturday,sunday.
            - times_a_week must be in 1,2,3,4,5.
            - time_per_day must be in 10,15,20,25,30,35,40.
            - pushups must be in 1,2,3,4,5.
            - plank must be in 1,2,3,4,5.
            - knee must be in Yes/No/A little.
            - height and weight mmust be greater than zero.
        Coach Validation:
            - description is required but no constraints just text.
            - the phone must be a 10 digit number so they should add the 09 without +963.
            - coach_num is a six digit number and it should be pre-initiated by an admin of the application so if a new coach wanted to enter the application he must contact an admin beforehand and said admin will generate his coach_num then we will give it to him so he can enter it at sign up.
LogIn:
    Validation(login):
        - email field and password field are required.
        - email field could contain either the email or the username (i just named it email).
    Responses(login):
        - there will always be a success field.
        - success = false ====> user was not found/ user was found but password was wrong either way there will be a message with it and frontend should only prin the message without manipulation.
        - success = true ====> a field called token will have the access token example: 
        {"success": true,"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNDZiNjgxNWEyODA2NTc2YTg5MTA1OTA3NDY2ZTJjYzRlNTY0NzBkZmMzMWUxN2NlNDZmOTFhMThjNjdjMmMyYjZjZDZmNTEyNGVjNjFlZGYiLCJpYXQiOjE2NTIzOTcyNDkuMjgwNDc1LCJuYmYiOjE2NTIzOTcyNDkuMjgwNDc2LCJleHAiOjE2ODM5MzMyNDkuMjc1OTMyLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.oT_bbyVB-ZuIpPaL9TFplyBU9BJsGT4df3-HKYgWyIy8OsYoSdwH7smMRBP44mcY4u_Kc10pMyI0ADkJX_pnXBTc-RKWvNjSW-tm__H6QNIJZUwZwrRFfGv2FCabPbj7o2zRlAQV9AZnrep5UrcUe7rYREhMrAW-YI8XrqBy2UvdHH1ovqB_u-6ENX9Rix8adxgnaAG1vVps_9ixeZZeM45dl6i0XweJoGtIbem0_EcceOZ9eHRvxeWJiLj33fUnA_kADwX_xQT3wz95bF9iD2Yekj4ZLmpOKw-G3aJ2amtgViYIWCzf5HMjSOOJH972BTC0kPqQPd8hIlI2KrwenE-hgPwbkowp73LZTucyb6etuM_5RvrQibA90YGb2JM9Bus9-lRR9Ew6o5f--xjVyuXRQhV2eJEebUgpwrEVkXvkFUh7cLPruME8Vd5XIHER052jTfq5v-7XfDAYnaCzr7RiDmwv0ZgmGM87xWjc-Ccc4ugC0H3nnF4S_waSEg3rzB_nYYKKlXbb4ppSpJ9pnKJpHdEIv8JnnqtKSVXgQnABqD959MrEDGIFF9tMoY9agBxcnRCVhoO6ojCWXKKRKUDhiJo7Ifw0T90C25WWah0L_6fc2reGx31D_x4FeXbJpmLZGvNpEoA0jChDbkatHtlPXQrpgSbBeH6weCdKrrM"}.
Logout/splash:
    Responses(logout):
        - success = true ===> logged out successfuly.
        - anything else there was an error.
        - either success = true or status= 200 will mean success if not successful then there will be an error message without success field.
