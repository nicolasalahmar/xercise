<h1 align = 'center'>Xercise</h1>
<h4>Introduction: </h4>
<p>Xercise is a health companion and Home workout platform for collaboration between trainees and coaches with the aim to better the health of users by helping professional coaches with professional experience reach a wider audience of people who want to workout but outside of a gym.<br/>
</p>

<p>this project was submitted as the main project of the Third year in the Faculty of Information Technology Engineering - Damascus University</p>

<h4>Remarks about the workout library:</h4>
<ul>
<li>the workout library is stored in the exercise seeder because we need to seed the database with the exercises in addition to the mobile app which will store the library as well in json format.</li>
<li>the exercise library was designed to be compatible with downloading in portions in case we supply the mobile app with a download manager so it could download the exercises one at a time depending on need.</li>
</ul>


<h4>Remarks about Authentication:</h4>
<ul>
<li>Authentication provider in use is passport which provides Oauth2 authorization protocol.</li>
<li>Tokens generated fall under two categories(scopes): trainee and coach, in order to protect trainee methods from being accessed by coaches and vice versa, Which allowed the implementation of RBAC using built in middlewares that filter out coach requests and trainee requests.</li>
<li>Support for the token type of admin was added but without the implementation of actual methods for admin type.</li>
<li>Support for web access and the impementation of a web page was added in authorization through guards specific for web access but without implementation of an actual website.</li>
</ul>




<h4>Technologies Used: </h4><ul>
<li>Laravel PHP Framework</li>
<li>MySQL RDBMS</li>
<li>Python Scripts for exercise library manipulation</li>
</ul>


<footer>
<h4><strong>Contributors:<strong></h4>
<h6>Backend</h6>
<ul><li>George Kassar</li><li>Haidar Al-Sous</li><li>Nicolas Al-Ahmar</li></ul>
<h6>Frontend</h6>
<ul><li>Marianne Deeb</li><li>Hrayr Derbededrossian</li></ul>
</footer>
