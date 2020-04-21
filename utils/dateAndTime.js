export const dateFormatter = (dateStringOrObj, options) => {
	const date = new Date(dateStringOrObj)
	console.log(date)
	if (typeof date.getTime() !== 'number') {
		throw new Error('Enter a valid date.')
	}
	
	const format = options && options.format ? options.format : 'ddmmyyyy',
		separator = options && options.separator ? options.separator : '.',
		year = date.getFullYear(),
		month = date.getMonth()+1,
		day = date.getDate();
	if (format === 'ddmmyyyy') return `${day}${separator}${month}${separator}${year}`
	if (format === 'yyyymmdd') return `${year}${separator}${month}${separator}${day}`
	if (format === 'mmddyyyy') return `${month}${separator}${day}${separator}${year}`
}
