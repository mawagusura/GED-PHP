import {
  addWrapper,
  capitalizePrint
} from './functions'
import Print from './print'

export default {
  print: (params, printFrame) => {
    // Check if we received proper data
    if (typeof params.printable !== 'object') {
      throw new Error('Invalid javascript data object (JSON).')
    }

    // Check if the repeatTableHeader is boolean
    if (typeof params.repeatTableHeader !== 'boolean') {
      throw new Error('Invalid value for repeatTableHeader attribute (JSON).')
    }

    // Check if properties were provided
    if (!params.properties || typeof params.properties !== 'object') throw new Error('Invalid properties array for your JSON data.')

    // Variable to hold the html string
    let htmlData = ''

    // Check if there is a header on top of the table
    if (params.header) htmlData += '<h1 style="' + params.headerStyle + '">' + params.header + '</h1>'

    // Build the printable html data
    htmlData += jsonToHTML(params)

    // Store the data
    params.htmlData = addWrapper(htmlData, params)

    // Print the json data
    Print.send(params, printFrame)
  }
}

function jsonToHTML (params) {
  // Get the row and column data
  let data = params.printable
  let properties = params.properties

  // Create a html table
  let htmlData = '<table style="border-collapse: collapse; width: 100%;">'

  // Check if the header should be repeated
  if (params.repeatTableHeader) {
    htmlData += '<thead>'
  }

  // Add the table header row
  htmlData += '<tr>'

  // Add the table header columns
  for (let a = 0; a < properties.length; a++) {
    htmlData += '<th style="width:' + 100 / properties.length + '%; ' + params.gridHeaderStyle + '">' + capitalizePrint(properties[a]) + '</th>'
  }

  // Add the closing tag for the table header row
  htmlData += '</tr>'

  // If the table header is marked as repeated, add the closing tag
  if (params.repeatTableHeader) {
    htmlData += '</thead>'
  }

  // Create the table body
  htmlData += '<tbody>'

  // Add the table data rows
  for (let i = 0; i < data.length; i++) {
    // Add the row starting tag
    htmlData += '<tr>'

    // Print selected properties only
    for (let n = 0; n < properties.length; n++) {
      let stringData = data[i]

      // Support nested objects
      let property = properties[n].split('.')
      if (property.length > 1) {
        for (let p = 0; p < property.length; p++) {
          stringData = stringData[property[p]]
        }
      } else {
        stringData = stringData[properties[n]]
      }

      // Add the row contents and styles
      htmlData += '<td style="width:' + 100 / properties.length + '%;' + params.gridStyle + '">' + stringData + '</td>'
    }

    // Add the row closing tag
    htmlData += '</tr>'
  }

  // Add the table and body closing tags
  htmlData += '</tbody></table>'

  return htmlData
}
