
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('4b3d19212d902a3e44e3', {
    cluster: 'ap1'
});

var channel = pusher.subscribe('overtime-channel');
channel.bind('overtime-event', function (data) {
    var notifId = data.notif_Id;
    var result = data.employee;
    var message = data.message;
    var reason = data.reason;
    var url = data.url;
    var id = $('#user-id').attr('data-id');
    var condition = '';
    var notif_mess = '';
    // Split first name by spaces
    var firstNameParts = result.first_name.split(' ');

    // Split last name by spaces
    var lastNameParts = result.last_name.split(' ');

    // Capitalize the first letter of each word in first name
    var capitalizedFirstName = firstNameParts.map(function (word) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    }).join(' ');

    // Capitalize the first letter of each word in last name
    var capitalizedLastName = lastNameParts.map(function (word) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    }).join(' ');

    if (message == "Approved") {
        condition = result.id == id;
        notif_mess = "Your Overtime has been Approved.";
    } else {
        condition = result.supervisor_id == id || result.manager_id == id;
        notif_mess = message + ' : ' + capitalizedFirstName + capitalizedLastName;
    }

    if (condition) {
        // Show Toastify notification
        Toastify({
            text: "New message arrived ",
            duration: 5000, // Duration in milliseconds
            gravity: "top", // Position of the notification: 'top', 'bottom', 'left', 'right'
            close: true // Whether to enable the close button
        }).showToast();
        // Add the 'notify-signal' class to the <span> tag inside the bell icon
        $('.fa.fa-bell-o.rel > span').addClass('notify-signal');

        // Get the current time
        var currentTime = new Date();
        $('.no_notif').addClass('d-none');
        // Append new result to list
        var listItem = $(`
              <a class="list-group-item">
                  <div class="media">
                  <i class="fa fa-circle" aria-hidden="true" style="font-size:8px;color:red;position:absolute;margin-left:27px;margin-top:-4px"></i>
                      <div class="media-img">
                          <span class="badge badge-warning badge-big"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                      </div>
                      <div class="media-body">
                          <div class="font-13" style="color:black">
                          <form action="<?= url('overtime/updateUnread') ?>" method="post">
                          {{ csrf_field() }}
                          <input type="hidden" name="Id" value="${notifId}">
                          <input type="hidden" name="Url" value="${url}">
                          <button type="submit" style="background-color:transparent;border:none;text-align:left;cursor: pointer;"><b>${notif_mess}</b><small class="text-muted" style="margin-left:5px"></small></button>
                          </form>
                          </div>
                           <!-- Display time ago -->
                      </div>
                  </div>
              </a>
              `);

        // Calculate the time difference for this item
        var dataTime = new Date();
        var timeDifference = Math.floor((currentTime.getTime() - dataTime.getTime()) / (1000 * 60));
        var timeAgo = (timeDifference === 0 || timeDifference === -1) ? 'just now' : timeDifference + ' mins ago';
        listItem.find('.text-muted').text(timeAgo);

        // Append the item to the list if total results are less than 5
        var tres = $('.list-group-item-dy').find('a.list-group-item').length;
        if (tres < 5) {
            $('.list-group-item-dy').prepend(listItem);
        }
        var totalResults = $('.list-group-item-dy').find('a.list-group-item').length;
        var count = parseInt($('.count').text()); // Parse the text content to an integer
        var totalCount = totalResults + count;

        // Count total results and update the .total element
        $('.total').text(totalCount);
        $('.envelope-badge').text(totalCount);

        // Update time every minute
        setInterval(function () {
            currentTime = new Date();
            timeDifference = Math.floor((currentTime.getTime() - dataTime.getTime()) / (1000 * 60));
            timeAgo = (timeDifference === 0 || timeDifference === -1) ? 'just now' : timeDifference + ' mins ago';
            listItem.find('.text-muted').text(timeAgo);
        }, 60000); // Update every minute (60 seconds)
    }
});

// Define the updateTime() function, which updates the displayed time
function updateTime() {
    // Select all elements with the class "createdAt"
    const timestamps = document.querySelectorAll(".createdAt");

    // Iterate over each element with the class "createdAt"
    timestamps.forEach(timestampElement => {
        // Get the timestamp from the "data-timestamp" attribute
        const timestamp = timestampElement.dataset.timestamp;

        // Parse the timestamp string into a Date object
        const createdAt = new Date(timestamp);

        // Get the current time
        const current_time = new Date();

        // Calculate the time difference between the current time and the timestamp
        const time_diff = current_time - createdAt;

        // Calculate the time difference in minutes, hours, days, months, and years
        const minutes = Math.floor(time_diff / (1000 * 60));
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);
        const months = Math.floor(days / 30);
        const years = Math.floor(days / 365);

        // Update the text content of the next sibling element with the calculated time
        if (minutes < 60) {
            // Display "X minutes ago" if less than an hour
            if (minutes === 0) {
                timestampElement.nextElementSibling.innerText = "Just now";
            } else if (minutes === 1) {
                timestampElement.nextElementSibling.innerText = "1 minute ago";
            } else {
                timestampElement.nextElementSibling.innerText = minutes + " minutes ago";
            }
        } else if (hours < 24) {
            // Display "X hours ago" if less than a day
            if (hours === 1) {
                timestampElement.nextElementSibling.innerText = "1 hour ago";
            } else {
                timestampElement.nextElementSibling.innerText = hours + " hours ago";
            }
        } else if (days < 30) {
            // Display "X days ago" if less than a month
            if (days === 1) {
                timestampElement.nextElementSibling.innerText = "1 day ago";
            } else {
                timestampElement.nextElementSibling.innerText = days + " days ago";
            }
        } else if (months < 12) {
            // Display "X months ago" if less than a year
            if (months === 1) {
                timestampElement.nextElementSibling.innerText = "1 month ago";
            } else {
                timestampElement.nextElementSibling.innerText = months + " months ago";
            }
        } else {
            // Display "X years ago" for longer durations
            if (years === 1) {
                timestampElement.nextElementSibling.innerText = "1 year ago";
            } else {
                timestampElement.nextElementSibling.innerText = years + " years ago";
            }
        }


        // Store the calculated "X minutes ago" or "X hours ago" value in local storage
        localStorage.setItem(timestamp, timestampElement.nextElementSibling.innerText);
    });
}

// Call updateTime() when the page loads
window.addEventListener('load', updateTime);

// Update time every minute using setInterval
setInterval(updateTime, 60000); // 60000 milliseconds = 1 minute
