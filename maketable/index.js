const express = require('express')
const app = express()
const port = 3000
const listOfItems = {
  "benefits": [{
      "GTX-780ti": {
        "name": "OP-HealthCare",
        "price": 120,
        "date": "2015-06-11"
      }
    },
    {
      "XFX-280x": []
    },
    {
      "970": {
        "additionalInfo": {
          "name": "LifeInsurance",
          "price": 50,
          "date": "2015-04-23"
        }
      }
    },
    {
      "HD6870": {
        "name": "LTD",
        "price": "$60.00",
        "date": "May 5, 2015"
      }
    }
  ]
}
// listOfItem to array


app.get('/', (req, res) => {
  var benefits = listOfItems.benefits;
  // get the key of benefits
  var benefit_key = Object.keys(benefits);
  // get the value of benefits
  var benefit_value = Object.values(benefits);
  // create new array
  var benefit_list_items = [];

  for (var k in benefits) {
    console.log(k)
    // get the key of benefits
    var benefit_key = Object.keys(benefits[k]);
    console.log("Keys: ", benefit_key)
    // get the value of benefits
    var benefit_value = Object.values(benefits[k]);
    benefit_row = {
      "code": benefit_key[0],
      ...hasAdditionalInfo(benefit_value[0])
    }    
    benefit_list_items.push(benefit_row)

  }

  console.log(JSON.stringify(benefit_list_items))
  displayTable(benefit_list_items, res)

})

app.listen(port, () => {
  console.log(`Go to  localhost:${port}`)
})

function displayTable(obj, res) {
  let result = `<table border=1><tr>
  <td>Benefit Name</td>
  <td>Cost</td>
  <td>Benefit Date</td>
  <td>Code</td>
</tr>`
  for (let index in obj) {
    result += `<td> ${convertToNone(obj[index].name)} </td>
    
    <td>${
      convertToCurrency(obj[index].price)}</td> <td>${
        convertToDate(obj[index].date)}</td> <td>${obj[index].code}</td></tr>`
  }
  result += '</table>'
  res.send(result)
}

function hasAdditionalInfo(obj) {
  if (obj.hasOwnProperty("additionalInfo")) {
    return obj["additionalInfo"]
  } else {
    return obj
  }
}

// convert digit to $00.00
function convertToCurrency(price) {
  if (price == undefined) {
    return "$00.00"
  }
  if (price != null && !isNaN(price)) {
    return "$" + price.toFixed(2);
  } else {
    return price
  }
}

// convert date to May 5, 2015
function convertToDate(date) {
  if (date != undefined) {
    // convert date to May 5, 2015
    var d = new Date(date)
    var month = d.toLocaleString('default', {
      month: 'short'
    })
    var day = d.getDate()
    var year = d.getFullYear()
    return month + " " + day + ", " + year
  } else {
    return "mm-dd-yyyy"
  }
}

// convert undefined to None 
function convertToNone(str) {
  return str == undefined ? "None" : str
}