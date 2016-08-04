#JSON Files

####What are they? Were do they come from? What do they do??

**JSON (canonically pronounced /ˈdʒeɪsən/ JAY-sən; sometimes JavaScript Object Notation) is an open-standard format that uses human-readable text to transmit data objects consisting of attribute–value pairs.**


**JSON is the most common data format used for the transfer of data between browser(client side) and Web Server.**

**JSON is based on javascript originally but is now ported to a large number of languages ranging from traditional JS to PHP and even Java.**

**refer to RFC 7159 for a full semantic and security related information**

**Information used in this document was sourced from GOOGLE and WIKI. All information is open source and free to the general public**

- - - - - - -

## Some Basic Guide-lines for the Newbies(No worries we have all been their):

1. JSON files are written in plain text
	* no fancy markup languages
	* no programming logic is used

2. JSON files can be written using
	* basic text editor
	* Third party JSON editors
	* JSON tools provided within IDE's

3. JSON can have multiple data types
	* Number - a signed decimal value in the real mathmatical domain
	* String - a sequence of proper unicode charaters
	* Boolean - of course TRUE or FALSE
	* Array - basic array structure (may be empty array)
	* Objects - an unordered collection of key=>value pairs associated with a certain object format, must follow proper object syntax.
	* Null
	* Note:: white space is allowed between data and ignored unless contained within a string value (more on this below)

* * * * * * *

## An Example:

	{
	  "firstName": "John",
	  "lastName": "Smith",
	  "isAlive": true,
	  "age": 25,
	  "address": {
	    "streetAddress": "21 2nd Street",
	    "city": "New York",
	    "state": "NY",
	    "postalCode": "10021-3100"
	  },
	  "phoneNumbers": [
	    {
	      "type": "home",
	      "number": "212 555-1234"
	    },
	    {
	      "type": "office",
	      "number": "646 555-4567"
	    },
	    {
	      "type": "mobile",
	      "number": "123 456-7890"
	    }
	  ],
	  "children": [],
	  "spouse": null
	}

## Translation Methods

1. JS
	1. Parsing JSON file:
		* var myObject = eval('(' + myJSONtext + ')');
			- Security Risk!
			- Will execute any JS code inside JSON file
		* var myObject = JSON.parse(myJSONtext, reviver);
			- "Safe" method
			- Parsing JSON instead of evaluating removes security risk

	2. Converting to string:
		* var myJSONText = JSON.stringify(myObject, replacer);
			- can be used in specific situations for evaluating JSON files


## JSON Syntax Rulles (as provided by W3schools):

	* DATA is in NAME=>VALUE pairs
	* DATA pairs are seperated by commas
	* Curly Braces {} are used to hold or denote objects
	* Square Brackets [] are use for denoting array values


Thanks, For Checking out the ol JSON stuff

	This information is free to use and distribute have fun!
	send any ?s or comments to furtwenty2@gmail.com