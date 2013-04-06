<?php
include("_parts/functions.php");
// include("_parts/connection.php");

// HTML parts
include("_parts/html_head.php");
include("_parts/header.php");
?>

<div class="container">
  <div class="row">
    <div class="threecol">
      <!--  Contact Information -->
      <address>
      <p><img border="0" alt=" "  src="http://tfsc.uark.edu/WCTFSC_color_version.png" /> </p>
      <p>Harmon Avenue Parking Facility<br />
      146 N. Harmon Avenue<br />
      HAPF-703<br />
      Fayetteville, AR 72701</p>
      <p>Lori L. Libbert<br />
      Special Events Manager</p>
      <p>P: 479-575-3222<br />
      F: 479-575-7086<br />
      <a  href="mailto:tfsc@uark.edu">tfsc@uark.edu</a></p>
      </address>
    </div>
    <!-- Form to post data-->
    <div class="sixcol centerPlate">
        <h1>Teaching Assistant Luncheon Survey</h1>
        <p><strong>Food for Thought: </strong>The TFSC Co-Directors are looking for feedback concerning our programming.
          We gave you food, you give us thoughts. (See, there really is no such thing as a free lunch!)</p>
        <FORM>           
          </br>
            <table align="center" witdh="100%">
              <tr>
                <td colspan = "5">
                  1. On a scale of 1 to 5, with 1 being "very unsatisfied" and 5 being "very satisfied" please indicate your overall level of satisfaction with today's Teaching Assistant Lunch presentation.
                </td>
              </tr>
              <tr>
                <td height = "7px"></td>
              </tr>
              <tr>
                <td  width="120px">
                  Very Unsatisfied</br>
                  1<input type = "radio" name ="TA1" value = "">
                </td>
                <td width="120px">
                  </br>
                  2<input type = "radio" name ="TA1" value = "">
                </td>
                <td width="120px">
                  </br>
                  3<input type = "radio" name ="TA1" value = "">
                </td>
                <td width="120px">
                  </br>
                  4<input type = "radio" name ="TA1" value = "">
                </td>
                <td width="120px">
                  Very Satisfied</br>
                  5<input type = "radio" name ="TA1" value = "">
                </td>
              </tr>
              <tr>
                <td height = "20px"></td>
              </tr>
              <tr>
                <td colspan = "5">
                  2. How satisfied were you with the meal provided?
                </td>                
              </tr>
              <tr>
                <td height = "7px"></td>
              </tr>
              <tr>
                <td  width="120px">
                  Very Unsatisfied</br>
                  1<input type = "radio" name ="TA2" value = "">
                </td>
                <td width="120px">
                  </br>
                  2<input type = "radio" name ="TA2" value = "">
                </td>
                <td width="120px">
                  </br>
                  3<input type = "radio" name ="TA2" value = "">
                </td>
                <td width="120px">
                  </br>
                  4<input type = "radio" name ="TA2" value = "">
                </td>
                <td width="120px">
                  Very Satisfied</br>
                  5<input type = "radio" name ="TA2" value = "">
                </td>
              </tr>
              <tr>
                <td height = "20px"></td>
              </tr>
              <tr>
                <td colspan = "5">
                  3. What is the likelihood you would attend another Teaching Assistant Luncheon? 
                </td>
              </tr>
              <tr>
                <td height = "7px"></td>
              </tr>
              <tr>
                <td  width="120px">
                  Very Unlikely</br>
                  1<input type = "radio" name ="TA3" value = "">
                </td>
                <td width="120px">
                  </br>
                  2<input type = "radio" name ="TA3" value = "">
                </td>
                <td width="120px">
                  </br>
                  3<input type = "radio" name ="TA3" value = "">
                </td>
                <td width="120px">
                  </br>
                  4<input type = "radio" name ="TA3" value = "">
                </td>
                <td width="120px">
                  Very Likely</br>
                  5<input type = "radio" name ="TA3" value = "">
                </td>
              </tr>
              <tr>
                <td height = "20px"></td>
              </tr>
              <tr>
                <td colspan = "5">
                  4. Recommendations for future Teaching Assistant Lunch topics: 
                </td>
              </tr>
              <tr>
                <td height = "7px"></td>
              </tr>
              <tr>
                <td colspan ="5"><textarea rows="3" cols="63"></textarea></td>
              </tr>
              <tr>
                <td height = "20px"></td>
              </tr>
              <tr>
                <td colspan = "5">
                  5. Additional Comments: 
                </td>
              </tr>
              <tr>
                <td height = "7px"></td>
              </tr>
              <tr>
                <td colspan ="5"><textarea rows="3" cols="63"></textarea></td>
              </tr>
              <tr>
                <td height = "40px"></td>
              </tr>
              <tr>
                <td colspan ="5" align="center"><input type ="submit" name = "next" value = "Submit" style="height:30px;width:80px;font-size:15px;"/> </td>
              </tr>
            </table>         
        </FORM> 
    </div>    
  </div>
</div>

<?php include("_parts/html_foot.php");
