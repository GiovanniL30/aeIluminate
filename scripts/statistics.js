const php = './backend/statistics.php'; 

const fetchUserOverviewData = async () => {
  try {
    const response = await fetch(php); 
    const data = await response.json();   
    console.log(data); // remove after debugging

    const { total_users, managers, alumni } = data;

    document.querySelector('#total-users').textContent = total_users;
    document.querySelector('#total-managers').textContent = managers;
    document.querySelector('#total-alumni').textContent = alumni;

  } catch (error) {
    console.error('Error fetching data:', error); 
  }
};

fetchUserOverviewData();
