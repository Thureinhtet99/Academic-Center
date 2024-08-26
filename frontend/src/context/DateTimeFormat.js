export default function dateTimeFormat(dateStr) {
    let date = new Date(dateStr);

    let monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let month = monthNames[date.getMonth()]; // 'Aug'
    let day = date.getDate().toString().padStart(2, '0'); // '02'
    let year = date.getFullYear(); // 2024

    return `${month} ${day}, ${year}`; // 'Aug 02, 2024'
};


