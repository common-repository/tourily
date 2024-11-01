<div class="wrap">

  <h2>Connect to Your Tourily.com Account</h2>

  <p>In order to connect this blog to your Tourily.com account, please
  enter your login details below. The plugin will be automatically
  configured.</p>

  <?php if (isset($bad_login)): ?>

    <p style="color:red">Login failed. Please enter your Tourily.com email / password.</p>

  <?php endif ?>

  <form method="POST" action="">

    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="tourily_email">Email</label>
        </th>
        <td><input type="text" name="tourily_email" id="tourily_email"></td>
      </tr>
       
      <tr valign="top">
        <th scope="row">
          <label for="tourily_password">Password</label>
        </th>
        <td><input type="password" name="tourily_password" id="tourily_password"></td>
      </tr>
    </table>
    
    <?php submit_button('Connect to Tourily') ?>

  </form>

</div>
