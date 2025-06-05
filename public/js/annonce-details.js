document.addEventListener('DOMContentLoaded', function() {
    const { reservedPeriods, annonceStartDate, annonceEndDate, dailyPrice } = window.reservationData;
    
    // Convert reserved periods to Date objects for easier manipulation
    const reservedDates = [];
    reservedPeriods.forEach(period => {
        let currentDate = new Date(period.start);
        const endDate = new Date(period.end);
        while (currentDate <= endDate) {
            reservedDates.push(new Date(currentDate));
            currentDate.setDate(currentDate.getDate() + 1);
        }
    });

    // Initialize calendar display
    function initCalendar() {
        const calendarContainer = document.getElementById('calendarContainer');
        if (!calendarContainer) return;

        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        function renderCalendar(month, year) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            
            let html = `
                <div class="calendar-header mb-4 flex justify-between items-center">
                    <button class="prev-month px-4 py-2 bg-gray-200 rounded-lg">&lt;</button>
                    <h3 class="text-xl font-bold">${new Date(year, month).toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })}</h3>
                    <button class="next-month px-4 py-2 bg-gray-200 rounded-lg">&gt;</button>
                </div>
                <div class="grid grid-cols-7 gap-1">
                    ${['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di'].map(day => `<div class="text-center font-bold py-2">${day}</div>`).join('')}
            `;

            // Add empty cells for days before the first day of the month
            for (let i = 0; i < firstDay.getDay(); i++) {
                html += `<div class="p-2"></div>`;
            }

           for (let day = 1; day <= daysInMonth; day++) {
    const currentDate = new Date(year, month, day);
    const isReserved = reservedDates.some(d => 
        d.getDate() === currentDate.getDate() && 
        d.getMonth() === currentDate.getMonth() && 
        d.getFullYear() === currentDate.getFullYear()
    );
    const isPast = currentDate < new Date(today.getFullYear(), today.getMonth(), today.getDate());
    const isAfterAnnonceEnd = annonceEndDate && currentDate > new Date(annonceEndDate);
    const isAvailable = !isReserved && !isPast && !isAfterAnnonceEnd;

    html += `
        <div class="p-2 text-center border rounded-lg 
            ${isReserved ? 'bg-red-100 text-red-800' : ''}
            ${isAvailable ? 'bg-green-100 text-green-800' : ''}
            ${isPast || isAfterAnnonceEnd ? 'text-gray-400' : ''}">
            ${day}
            ${isReserved ? '<span class="block text-xs font-bold">R</span>' : ''}
            ${isAvailable ? '<span class="block text-xs font-bold">D</span>' : ''}
        </div>
    `;
}
            html += `</div>`;
            calendarContainer.innerHTML = html;

            // Add event listeners for month navigation
            document.querySelector('.prev-month').addEventListener('click', () => {
                if (month === 0) {
                    month = 11;
                    year--;
                } else {
                    month--;
                }
                renderCalendar(month, year);
            });

            document.querySelector('.next-month').addEventListener('click', () => {
                if (month === 11) {
                    month = 0;
                    year++;
                } else {
                    month++;
                }
                renderCalendar(month, year);
            });
        }

        renderCalendar(currentMonth, currentYear);
    }

    // Initialize the calendar
    initCalendar();

    // Rest of your existing code (Flatpickr initialization and other functions)
    const disabledDates = reservedPeriods.map(period => ({
        from: period.start,
        to: period.end
    }));
    
    const dateDebutInput = flatpickr("#date_debut", {
        locale: "fr",
        minDate: "today",
        maxDate: annonceEndDate,
        disable: disabledDates,
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr) {
            dateFinInput.set('minDate', dateStr);
            dateFinInput.set('disable', disabledDates);
            calculatePrice();
            
            const priceCalc = document.getElementById('priceCalculation');
            if (priceCalc.classList.contains('hidden')) {
                priceCalc.classList.remove('hidden');
                priceCalc.classList.add('animate__fadeIn');
            }
        }
    });
    
    const dateFinInput = flatpickr("#date_fin", {
        locale: "fr",
        minDate: "today",
        maxDate: annonceEndDate,
        disable: disabledDates,
        dateFormat: "Y-m-d",
        onChange: function() {
            calculatePrice();
        }
    });
    
    function calculatePrice() {
        const startDate = dateDebutInput.selectedDates[0];
        const endDate = dateFinInput.selectedDates[0];
        
        if (startDate && endDate) {
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const totalPrice = diffDays * dailyPrice;
            
            document.getElementById('durationDays').textContent = diffDays;
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
            
            const totalPriceElement = document.getElementById('totalPrice');
            totalPriceElement.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                totalPriceElement.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        }
    }
    
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        const startDate = dateDebutInput.selectedDates[0];
        const endDate = dateFinInput.selectedDates[0];
        
        if (!startDate || !endDate) {
            e.preventDefault();
            showAlert('Veuillez sélectionner les dates de réservation.', 'error');
            return;
        }
        
        if (startDate > endDate) {
            e.preventDefault();
            showAlert('La date de fin doit être après la date de début.', 'error');
            return;
        }
        
        if (!checkAvailability(startDate, endDate)) {
            e.preventDefault();
            showAlert('Cette période n\'est plus disponible. Veuillez choisir d\'autres dates.', 'error');
        }
    });
    
    function checkAvailability(startDate, endDate) {
        return !reservedPeriods.some(period => {
            const periodStart = new Date(period.start);
            const periodEnd = new Date(period.end);
            
            return (startDate >= periodStart && startDate <= periodEnd) ||
                   (endDate >= periodStart && endDate <= periodEnd) ||
                   (startDate <= periodStart && endDate >= periodEnd);
        });
    }
    
    function showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `fixed top-20 right-4 p-4 rounded-lg shadow-lg text-white animate__animated animate__fadeInRight ${type === 'error' ? 'bg-red-500' : 'bg-green-500'}`;
        alert.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.classList.remove('animate__fadeInRight');
            alert.classList.add('animate__fadeOutRight');
            setTimeout(() => alert.remove(), 1000);
        }, 3000);
    }
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.toy-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('animate__animated', 'animate__pulse');
        });
        card.addEventListener('mouseleave', () => {
            card.classList.remove('animate__animated', 'animate__pulse');
        });
    });
    
});