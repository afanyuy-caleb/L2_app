<!-- About us section -->

<section class="section2" id="about">
    <h3 class="heading">About Us</h3>
    
    <div class="text-area">  

      <div class="description">
        <img src="<?=$path?>assets/images/logo/logo3.webp" alt=" there is an image here">
        <div class="desc">
          <h4>Description</h4>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quod quaerat esse distinctio, ab eveniet asperiores, aliquam quos fuga quasi deleniti pariatur adipisci quam enim nesciunt, accusamus earum error voluptate est voluptatibus commodi. Voluptas cumque, asperiores fugiat ipsam iste facere vitae iusto molestiae aperiam rerum, alias labore praesentium minus ab debitis quae reprehenderit modi? Labore minus aliquam corrupti facere nulla earum, fuga temporibus eos recusandae iure dolores voluptatibus nesciunt placeat eveniet, dolor quasi quod. Inventore tempora consectetur asperiores alias velit ipsum incidunt sequi hic dicta, maxime qui accusantium eaque ex.
          </p>

        </div>
        
      </div>
      
    </div>
  </section>

  <!-- Contact us section -->

  <section class="section3" id="contact">
    
    <h3 class="heading">Contact Us</h3>  

    <div class="text-area">  

      <div class="input-section">
        
        <form action="" method="POST">
          
          <p>Send to us a Message</p>

          <div class="input-part">
            <div class="input">
              <input type="text" id="fname" name="fname" required>
              <label for="fname">First name</label>
            </div>

            <div class="input">
              <input type="text" id="lname" name="lname" required>
              <label for="lname">Last name</label>
            </div>
          </div>
          
          
          <div class="input-part">
            <div class="input">
              <input type="number" id="number" name="number" required>
              <label for="number">Mobile Number</label>
            </div> 

            <div class="input">
              <input type="email" id="email" name="email" required>
              <label for="email">Email address</label>
            </div> 
          </div>
          
          <div class="textarea">
            <textarea name="text" id="text" required></textarea>
            <label for="text">Write your message here !!</label>

          </div>

          <a href="mailto:afanyuys@gmail.com"><input type="submit" name="send" value="Send"></a>
          
        </form>

        <div class="contact-details">
        Contact Details
        </div>

      </div>
  
    </div>
  </section>

  <script src="<?=$path?>assets/JS/script.js"></script>