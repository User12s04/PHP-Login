<div class = "container mt-5 bg-dark text-center ">
    <h2 class = "text-white">Sign Up</h2>
    <form action = "" method="post">        
        <label class="text-white" for="new-uname">New Username:</label><br>
        <input type="text" id="new-uname" name="new-uname"><br>
        <label class="text-white" for="pword">New Password</label><br>
        <input type="password" id="new-pword" name="new-pword" ><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

<h2>{$message}</h2>
<div>
{$smarty.session|@print_r}
</div>
