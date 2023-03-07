
{if isset($smarty.session.user)}
    <div class="alert alert-success" role="alert">
        You are Logged in
    </div> 
{else}
<div class = "container mt-5 bg-dark text-center ">
    <h2 class = "text-white">Sign In</h2>
    <form action = "" method="post">       
        <label class="text-white" for="uname">Username:</label><br>
        <input type="text" id="uname" name="uname"><br>
        <label class="text-white" for="pword">Password</label><br>
        <input type="password" id="pword" name="pword" ><br><br>
        <input type="submit" value="Submit">
    </form>
</div>
{/if}

