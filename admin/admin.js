// Your custom JavaScript function that checks the condition
// function bndtls_frontpage_allow_isset() { return false; }


function bndtls_frontpage_allow_isset()
{
  return false;
  if (front_page_allow.value.length == 0)
  {
    alert("empty");
    return false;
  }
  alert("set");
  return true;
}
//
// // Bind keyup event on the input
// $('#front_page_allow').keyup(function() {
//
//   // If value is not empty
//   if ($(this).val().length == 0) {
//     // Hide the element
//     $('.rwmb-checkbox-wrapper:has(#frontpage_full_content)').hide();
//   } else {
//     // Otherwise show it
//     $('.rwmb-checkbox-wrapper:has(#frontpage_full_content)').show();
//   }
// }).keyup(); // Trigger the keyup event, thus running the handler on page load
