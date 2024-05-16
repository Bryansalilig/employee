<style>
  .styled-checkbox {
  position: absolute; 
  opacity: 0; 
 
  & + label {
  position: relative;
  cursor: pointer;
  padding: 0;
  }
  & + label:before {
  content: '';
  margin-right: 10px;
  display: inline-block;
  vertical-align: text-top;
  width: 20px;
  height: 20px;
  background: white;
  border: 1px solid #D3D3D3;
  border-radius: 5px;
  }
  &:hover + label:before {
  background: #F8F8F8;
  }
  &:focus + label:before {
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
  }
  &:checked + label:before {
  background: #006bb3;
  }
  &:disabled + label {
  color: #b8b8b8;
  cursor: auto;
  }
  &:disabled + label:before {
  box-shadow: none;
  background: #ddd;
  }
  &:checked + label:after {
  content: '';
  position: absolute;
  left: 5px;
  top: 9px;
  background: white;
  width: 2px;
  height: 2px;
  box-shadow: 
  2px 0 0 white,
  4px 0 0 white,
  4px -2px 0 white,
  4px -4px 0 white,
  4px -6px 0 white,
  4px -8px 0 white;
  transform: rotate(45deg);
  }
  
  .unstyled {
  margin: 0;
  padding: 0;
  list-style-type: none;
  }
  li {
  margin: 20px 0;
  }
  .centered {
  width: 300px;
  margin: auto;
  }
  .title {
  text-align: center;
  color: rgb(69, 113, 236);
  }
</style>
<div class="row">
  <div class="col-md-12" style="border-right: 1px solid #eee;">
    <h3><b>RECOMMENDATION</b></h3>
    <p>(Put a check mark on appropriate recommendation)</p>
    <div class="col-md-12" style="display: flex; flex-wrap: wrap;">
      <div class="col-md-6" style="flex: 0 0 50%;">
        <input class="styled-checkbox" type="checkbox" name="recommendations[]" value="REGULARIZATION" id="checkbox1">
        <label for="checkbox1">REGULARIZATION</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
        <input class="styled-checkbox" type="checkbox" name="recommendations[]" value="PROMOTION" id="checkbox2">
        <label for="checkbox2">PROMOTION</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
        <input class="styled-checkbox" type="checkbox" name="recommendations[]" value="TERMINATE PROBATION" id="checkbox3">
        <label for="checkbox3">TERMINATE PROBATION</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
        <input class="styled-checkbox" type="checkbox" name="recommendations[]" value="SALARY INCREASE" id="checkbox4">
        <label for="checkbox4">SALARY INCREASE</label>
      </div>
      <div class="col-md-6" style="flex: 0 0 50%;">
        <input class="styled-checkbox" type="checkbox" name="recommendations[]" value="EXTEND PROBATION" id="checkbox5">
        <label for="checkbox5">EXTEND PROBATION</label>
      </div>
    </div>
    <div class="form-group mt-3 text-right">
      <button class="btn btn-default btn-tab" data-tab="government">Previous</button>
      <button class="btn btn-info" type="button" onclick="validateRecommendation()">Submit</button>
    </div>
  </div>
</div>
<script type="text/javascript">
  const validateRecommendation = () => {
    const checkboxes = document.querySelectorAll('input[name="recommendations[]"]');

    const checkboxValue = Array.from(checkboxes).some(checkbox => checkbox.checked);

    if(checkboxValue){
      document.querySelector('#createId').submit();
    } else {
      alert('Please select atleast one recommendation');
    }
  }
</script>