<!-- ======================================================== -->
<!-- MODALES INTERACTIVOS: AGENDAMIENTO, MEMBRESÍAS & PUSH PWA -->
<!-- ======================================================== -->

<!-- 1. MODAL DE AGENDAMIENTO DE CITAS -->
<div class="appt-modal-backdrop" id="apptModalBackdrop" onclick="closeAppointmentsModal()"></div>
<div class="appt-modal" id="apptModal" role="dialog" aria-modal="true" aria-labelledby="apptModalTitle">
    <div class="appt-modal-header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="appt-icon-badge">📅</div>
            <div>
                <h3 id="apptModalTitle" style="font-size: 17px; font-weight: 800; margin: 0; color: var(--ink);">Citas y Agenda en Línea</h3>
                <span style="font-size: 12px; color: var(--muted);">Reserva en tiempo real con confirmación inmediata</span>
            </div>
        </div>
        <button type="button" class="appt-close-btn" onclick="closeAppointmentsModal()" aria-label="Cerrar modal">✕</button>
    </div>

    <!-- TABS -->
    <div class="appt-tabs-bar">
        <button type="button" class="appt-tab-btn active" id="tabBtnNewAppt" onclick="switchApptTab('new')">
            Reservar Nueva Cita
        </button>
        <button type="button" class="appt-tab-btn" id="tabBtnMyAppts" onclick="switchApptTab('my')">
            <span>📋</span> Mis Citas Agendadas
        </button>
    </div>

    <!-- TAB CONTENT 1: NUEVA CITA -->
    <div class="appt-tab-pane active" id="paneNewAppt">
        <div class="appt-steps-indicator">
            <div class="appt-step-item active" id="stepInd1">1. Servicio</div>
            <div class="appt-step-arrow">›</div>
            <div class="appt-step-item" id="stepInd2">2. Especialista</div>
            <div class="appt-step-arrow">›</div>
            <div class="appt-step-item" id="stepInd3">3. Horario</div>
            <div class="appt-step-arrow">›</div>
            <div class="appt-step-item" id="stepInd4">4. Confirmar</div>
        </div>

        <form id="appointmentBookingForm" onsubmit="submitAppointmentForm(event)">
            <!-- STEP 1: SELECCIÓN DE SERVICIO -->
            <div class="appt-form-step active" id="stepBox1">
                <h4 class="appt-step-title">Selecciona el Servicio que deseas agendar:</h4>
                <div class="appt-services-grid" id="apptServicesContainer">
                    <div class="appt-loading-spinner">Cargando catálogo de servicios...</div>
                </div>
            </div>

            <!-- STEP 2: SELECCIÓN DE ESPECIALISTA -->
            <div class="appt-form-step" id="stepBox2">
                <h4 class="appt-step-title">Selecciona con quién deseas atenderte:</h4>
                <div class="appt-staff-grid" id="apptStaffContainer">
                    <div class="appt-loading-spinner">Cargando profesionales...</div>
                </div>
            </div>

            <!-- STEP 3: FECHA Y HORARIO -->
            <div class="appt-form-step" id="stepBox3">
                <h4 class="appt-step-title">Selecciona la Fecha y Horario disponible:</h4>
                <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 16px;">
                    <div style="flex: 1; min-width: 180px;">
                        <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--muted); margin-bottom: 6px;">FECHA DE LA CITA</label>
                        <input type="date" id="apptDateInput" class="appt-input" onchange="fetchAvailableSlots()" required>
                    </div>
                </div>
                <label style="display: block; font-size: 11.5px; font-weight: 700; color: var(--muted); margin-bottom: 6px;">HORARIOS DISPONIBLES EN TIEMPO REAL</label>
                <div class="appt-slots-container" id="apptSlotsContainer">
                    <div style="text-align: center; color: var(--muted); font-size: 12.5px; padding: 20px;">
                        Selecciona una fecha para consultar la disponibilidad.
                    </div>
                </div>
            </div>

            <!-- STEP 4: DATOS DEL CLIENTE Y CONFIRMACIÓN -->
            <div class="appt-form-step" id="stepBox4">
                <h4 class="appt-step-title">Tus Datos de Contacto para la Cita:</h4>
                <div class="appt-summary-card" id="apptSummaryCard">
                    <!-- Populated dynamically -->
                </div>

                <div class="appt-fields-grid">
                    <div>
                        <label class="appt-field-label">Nombre Completo *</label>
                        <input type="text" id="apptClientName" class="appt-input" placeholder="Tu nombre y apellido" required value="{{ $user->name ?? '' }}">
                    </div>
                    <div>
                        <label class="appt-field-label">Teléfono / WhatsApp *</label>
                        <input type="tel" id="apptClientPhone" class="appt-input" placeholder="Ej: 4921234567" required>
                    </div>
                    <div>
                        <label class="appt-field-label">Correo Electrónico</label>
                        <input type="email" id="apptClientEmail" class="appt-input" placeholder="tucorreo@ejemplo.com" value="{{ $user->email ?? '' }}">
                    </div>
                    <div>
                        <label class="appt-field-label">Notas o Requerimientos Especiales</label>
                        <input type="text" id="apptClientNotes" class="appt-input" placeholder="Alguna petición en particular...">
                    </div>
                </div>
            </div>

            <!-- STEP NAVIGATION FOOTER -->
            <div class="appt-form-footer">
                <button type="button" class="btn-appt-back" id="btnApptBack" onclick="prevApptStep()" style="display: none;">
                    ‹ Anterior
                </button>
                <div style="flex: 1;"></div>
                <button type="button" class="btn-appt-next" id="btnApptNext" onclick="nextApptStep()">
                    Siguiente ›
                </button>
                <button type="submit" class="btn-appt-submit" id="btnApptSubmit" style="display: none;">
                    ✓ Confirmar y Reservar Cita
                </button>
            </div>
        </form>

        <!-- CONFIRMATION RECEIPT SCREEN (Hidden by default) -->
        <div class="appt-success-screen" id="apptSuccessScreen" style="display: none;">
            <div class="appt-success-badge">✓</div>
            <h3 style="font-size: 19px; font-weight: 800; color: #15803d; margin: 10px 0 4px;">¡Cita Reservada con Éxito!</h3>
            <p style="font-size: 13px; color: var(--muted); margin: 0 0 16px;">Hemos agendado tu espacio y enviado una confirmación a tu contacto.</p>

            <div class="appt-ticket-card" id="apptTicketContent">
                <!-- Populated dynamically -->
            </div>

            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 18px; flex-wrap: wrap;">
                <button type="button" class="btn-appt-done" onclick="closeAppointmentsModal()">
                    Volver a la Tienda
                </button>
                <button type="button" class="btn-appt-share-wa" id="btnApptShareWa" onclick="shareApptWhatsApp()">
                    📱 Enviar a WhatsApp
                </button>
            </div>
        </div>
    </div>

    <!-- TAB CONTENT 2: MIS CITAS -->
    <div class="appt-tab-pane" id="paneMyAppts">
        <div style="padding: 12px 0;">
            <div style="display: flex; gap: 10px; margin-bottom: 16px;">
                <input type="text" id="myApptSearchInput" class="appt-input" placeholder="Ingresa tu teléfono o correo..." value="{{ $user->email ?? '' }}">
                <button type="button" class="btn-appt-next" onclick="loadMyAppointments()" style="white-space: nowrap;">
                    🔍 Buscar Citas
                </button>
            </div>
            <div id="myAppointmentsList" class="my-appts-list">
                <div style="text-align: center; color: var(--muted); padding: 30px; font-size: 13px;">
                    Consulta tus citas programadas ingresando tu número o correo registrado.
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 2. MODAL DE CENTRO DE MEMBRESÍAS & SOCIOS VIP -->
<div class="appt-modal-backdrop" id="membModalBackdrop" onclick="closeMembershipsModal()"></div>
<div class="appt-modal" id="membModal" role="dialog" aria-modal="true" aria-labelledby="membModalTitle">
    <div class="appt-modal-header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="appt-icon-badge" style="background: rgba(234, 179, 8, 0.15); color: #ca8a04;">⭐</div>
            <div>
                <h3 id="membModalTitle" style="font-size: 17px; font-weight: 800; margin: 0; color: var(--ink);">Club de Membresías &amp; Puntos</h3>
                <span style="font-size: 12px; color: var(--muted);">Tarjeta digital de socio, beneficios exclusivos y recompensas</span>
            </div>
        </div>
        <button type="button" class="appt-close-btn" onclick="closeMembershipsModal()" aria-label="Cerrar modal">✕</button>
    </div>

    <!-- TABS -->
    <div class="appt-tabs-bar">
        <button type="button" class="appt-tab-btn active" id="tabBtnMyCard" onclick="switchMembTab('card')">
            <span>💳</span> Mi Tarjeta Digital
        </button>
        <button type="button" class="appt-tab-btn" id="tabBtnExplorePlans" onclick="switchMembTab('plans')">
            <span>👑</span> Conocer Planes y Beneficios
        </button>
    </div>

    <!-- TAB 1: MI TARJETA DIGITAL -->
    <div class="appt-tab-pane active" id="paneMyCard">
        <div id="cardLookupBar" style="display: flex; gap: 10px; margin: 12px 0;">
            <input type="text" id="membershipCodeInput" class="appt-input" placeholder="Ingresa tu código de socio (ej: MEM-XXXXXX) o correo" value="{{ $user->email ?? '' }}">
            <button type="button" class="btn-appt-next" onclick="loadMyMembershipCard()" style="white-space: nowrap;">
                🔍 Consultar
            </button>
        </div>

        <div id="membershipCardContainer" style="padding: 10px 0;">
            <div style="text-align: center; color: var(--muted); padding: 40px; font-size: 13px;">
                Cargando estado de membresía...
            </div>
        </div>
    </div>

    <!-- TAB 2: EXPLORAR PLANES -->
    <div class="appt-tab-pane" id="paneExplorePlans">
        <div class="membership-plans-grid" id="membershipPlansContainer">
            <div class="appt-loading-spinner">Cargando planes de membresía disponibles...</div>
        </div>
    </div>
</div>


<!-- 3. BANNER ELEGANTE FLOTANTE PARA ACTIVAR NOTIFICACIONES PUSH -->
<div class="push-permission-pill" id="pushPermissionPill" style="display: none;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 20px;">🔔</span>
        <div>
            <strong style="font-size: 12.5px; display: block; color: #fff;">Recordatorios y Promociones en Tiempo Real</strong>
            <span style="font-size: 11px; color: rgba(255,255,255,0.75);">Recibe avisos de tus citas y beneficios en tu teléfono.</span>
        </div>
    </div>
    <div style="display: flex; gap: 6px; align-items: center;">
        <button type="button" class="btn-push-enable" onclick="enablePushNotifications()">Activar</button>
        <button type="button" class="btn-push-dismiss" onclick="dismissPushBanner()">✕</button>
    </div>
</div>


<!-- ESTILOS CSS RESPONSIVOS PARA CITAS, MEMBRESÍAS Y CERO SOBREPOSICIONES -->
<style>
/* Backdrop & Modal Shells */
.appt-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 100000;
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease;
}
.appt-modal-backdrop.open {
    opacity: 1;
    pointer-events: auto;
}

.appt-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.95);
    width: 680px;
    max-width: calc(100vw - 32px);
    max-height: 90vh;
    background: var(--card);
    border: 1.5px solid var(--card-border);
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    z-index: 100001;
    overflow-y: auto;
    opacity: 0;
    pointer-events: none;
    transition: transform .25s cubic-bezier(0.16, 1, 0.3, 1), opacity .25s ease;
    display: flex;
    flex-direction: column;
}
.appt-modal.open {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
    pointer-events: auto;
}

.appt-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--paper);
}
.appt-icon-badge {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: rgba(217, 107, 69, 0.12);
    color: var(--accent);
    display: grid;
    place-items: center;
    font-size: 20px;
}
.appt-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(148, 163, 184, 0.15);
    color: var(--ink);
    cursor: pointer;
    font-size: 14px;
    display: grid;
    place-items: center;
    transition: background .15s ease;
}
.appt-close-btn:hover { background: rgba(148, 163, 184, 0.3); }

/* Tabs Bar */
.appt-tabs-bar {
    display: flex;
    background: var(--paper);
    border-bottom: 1px solid var(--line);
    padding: 0 24px;
    gap: 8px;
}
.appt-tab-btn {
    padding: 12px 16px;
    border: none;
    background: transparent;
    color: var(--muted);
    font-weight: 700;
    font-size: 13.5px;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all .2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}
.appt-tab-btn.active {
    color: var(--accent);
    border-bottom-color: var(--accent);
}

.appt-tab-pane {
    display: none;
    padding: 24px;
    flex: 1;
}
.appt-tab-pane.active {
    display: block;
}

/* Step Indicators */
.appt-steps-indicator {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 18px;
    margin-bottom: 20px;
    border-bottom: 1px dashed var(--line);
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
}
.appt-step-item.active {
    color: var(--accent);
    text-decoration: underline;
    text-underline-offset: 4px;
}
.appt-step-arrow { color: var(--line); font-size: 14px; }

/* Step Box */
.appt-form-step { display: none; }
.appt-form-step.active { display: block; }
.appt-step-title {
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 16px;
    color: var(--ink);
}

/* Service Cards */
.appt-services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 12px;
    max-height: 340px;
    overflow-y: auto;
    padding: 2px;
}
.appt-service-card {
    padding: 14px;
    border-radius: 14px;
    border: 1.5px solid var(--card-border);
    background: var(--card);
    cursor: pointer;
    transition: all .2s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.appt-service-card:hover {
    border-color: var(--accent);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.06);
}
.appt-service-card.selected {
    border-color: var(--accent);
    background: rgba(217, 107, 69, 0.05);
    box-shadow: 0 0 0 2px var(--accent);
}

/* Staff Cards */
.appt-staff-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px;
    max-height: 340px;
    overflow-y: auto;
    padding: 2px;
}
.appt-staff-card {
    padding: 16px 12px;
    border-radius: 14px;
    border: 1.5px solid var(--card-border);
    background: var(--card);
    cursor: pointer;
    text-align: center;
    transition: all .2s ease;
}
.appt-staff-card:hover {
    border-color: var(--accent);
    transform: translateY(-2px);
}
.appt-staff-card.selected {
    border-color: var(--accent);
    background: rgba(217, 107, 69, 0.05);
    box-shadow: 0 0 0 2px var(--accent);
}
.appt-staff-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 10px;
    border: 2px solid var(--accent);
}

/* Time Slots */
.appt-slots-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(85px, 1fr));
    gap: 8px;
    max-height: 220px;
    overflow-y: auto;
    padding: 4px;
}
.appt-slot-btn {
    padding: 10px 6px;
    border-radius: 10px;
    border: 1.5px solid var(--line);
    background: var(--card);
    color: var(--ink);
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    transition: all .15s ease;
}
.appt-slot-btn:hover {
    border-color: var(--accent);
    background: rgba(217, 107, 69, 0.08);
}
.appt-slot-btn.selected {
    background: var(--accent);
    color: #ffffff;
    border-color: var(--accent);
}

/* Inputs & Form Controls */
.appt-input {
    width: 100%;
    padding: 11px 14px;
    border-radius: 12px;
    border: 1.5px solid var(--line);
    background: var(--card);
    color: var(--ink);
    font-size: 13.5px;
    font-family: inherit;
    outline: none;
    transition: border-color .15s ease;
    box-sizing: border-box;
}
.appt-input:focus { border-color: var(--accent); }
.appt-field-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 5px;
}
.appt-fields-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
@media (max-width: 600px) {
    .appt-fields-grid { grid-template-columns: 1fr; }
}

.appt-summary-card {
    padding: 14px 16px;
    border-radius: 14px;
    background: var(--paper);
    border: 1px solid var(--line);
    margin-bottom: 16px;
    font-size: 13px;
    line-height: 1.5;
}

/* Footer Buttons */
.appt-form-footer {
    display: flex;
    align-items: center;
    margin-top: 24px;
    padding-top: 16px;
    border-top: 1px solid var(--line);
    gap: 12px;
}
.btn-appt-next, .btn-appt-submit, .btn-appt-done {
    background: var(--accent);
    color: #ffffff;
    border: none;
    padding: 11px 22px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 13.5px;
    cursor: pointer;
    transition: opacity .15s ease, transform .15s ease;
}
.btn-appt-submit { background: #15803d; }
.btn-appt-next:hover, .btn-appt-submit:hover, .btn-appt-done:hover {
    opacity: 0.92;
    transform: translateY(-1px);
}
.btn-appt-back {
    background: transparent;
    border: 1.5px solid var(--line);
    color: var(--ink);
    padding: 10px 18px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
}
.btn-appt-share-wa {
    background: #25d366;
    color: #ffffff;
    border: none;
    padding: 11px 20px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 13.5px;
    cursor: pointer;
}

/* DIGITAL MEMBERSHIP CARD STYLES */
.digital-membership-card {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #ffffff;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 16px 36px rgba(0,0,0,0.25);
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
    border: 1.5px solid rgba(255,255,255,0.12);
}
.dmc-shine {
    position: absolute;
    top: -50%;
    right: -20%;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(234, 179, 8, 0.25) 0%, rgba(234, 179, 8, 0) 70%);
    pointer-events: none;
}
.dmc-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
}
.dmc-badge-pill {
    background: rgba(234, 179, 8, 0.2);
    color: #facc15;
    border: 1px solid rgba(234, 179, 8, 0.4);
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.dmc-code-box {
    font-family: monospace;
    font-size: 20px;
    letter-spacing: 3px;
    font-weight: 800;
    color: #f8fafc;
    margin: 14px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dmc-stats-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    margin-top: 18px;
    padding-top: 14px;
    border-top: 1px solid rgba(255,255,255,0.12);
}
.dmc-stat-col strong {
    display: block;
    font-size: 16px;
    font-weight: 800;
    color: #facc15;
}
.dmc-stat-col span {
    font-size: 10.5px;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 700;
}

/* Membership Plans Grid */
.membership-plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 16px;
    padding: 10px 0;
}
.membership-plan-card {
    background: var(--card);
    border: 2px solid var(--card-border);
    border-radius: 18px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform .2s ease, border-color .2s ease;
}
.membership-plan-card:hover {
    transform: translateY(-3px);
    border-color: var(--accent);
}
.mpc-price {
    font-size: 22px;
    font-weight: 900;
    color: var(--accent);
    margin: 10px 0;
}
.mpc-perks {
    list-style: none;
    padding: 0;
    margin: 12px 0 18px;
    font-size: 12px;
    color: var(--ink);
    line-height: 1.6;
}
.mpc-perks li::before {
    content: "✓ ";
    color: #15803d;
    font-weight: 800;
}

/* PUSH PERMISSION FLOATING PILL */
.push-permission-pill {
    position: fixed;
    bottom: calc(88px + env(safe-area-inset-bottom, 0px));
    left: 16px;
    right: 16px;
    max-width: 480px;
    margin: 0 auto;
    background: #0f172a;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 16px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    box-shadow: 0 16px 36px rgba(0,0,0,0.3);
    z-index: 99998;
    animation: slideUpPill .3s ease;
}
@keyframes slideUpPill {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.btn-push-enable {
    background: var(--accent);
    color: #fff;
    border: none;
    padding: 7px 14px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 12px;
    cursor: pointer;
}
.btn-push-dismiss {
    background: transparent;
    color: #94a3b8;
    border: none;
    font-size: 14px;
    cursor: pointer;
    padding: 4px;
}

/* ---------------------------------------------------- */
/* PREVENCIÓN ESTRICTA DE SOBREPOSICIONES EN TELÉFONOS */
/* ---------------------------------------------------- */
@media (max-width: 768px) {
    /* 1. Dar espacio seguro al fondo del body para que nada tape productos ni footer */
    body {
        padding-bottom: 0 !important;
    }
    .pwa-floating-bottom-bar {
        display: none !important;
    }
    .whatsapp-float {
        position: fixed !important;
        bottom: max(20px, env(safe-area-inset-bottom)) !important;
        right: 16px !important;
        width: 52px !important;
        height: 52px !important;
        z-index: 9999 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 8px 24px rgba(37, 211, 102, 0.45) !important;
    }
    .whatsapp-float svg {
        width: 28px !important;
        height: 28px !important;
        fill: #ffffff !important;
        stroke: none !important;
        display: block !important;
    }

    /* 4. Botón de Editor Visual para Administradores: Elevado arriba de WhatsApp */
    .btn-floating-visual-editor {
        bottom: calc(134px + env(safe-area-inset-bottom, 0px)) !important;
        left: 16px !important;
        z-index: 9996 !important;
        font-size: 11px !important;
        padding: 6px 12px !important;
    }

    /* 5. Modales en pantalla completa cómoda en teléfonos */
    .appt-modal {
        width: 95vw !important;
        max-height: 92vh !important;
        border-radius: 18px !important;
    }
    .appt-modal-header { padding: 14px 16px !important; }
    .appt-tab-pane { padding: 16px !important; }
}
</style>


<!-- JAVASCRIPT LOGIC FOR APPOINTMENTS, MEMBERSHIPS & WEBPUSH -->
<script>
(function() {
    const TENANT_ID = @json($tenantId ?? '');
    let currentStep = 1;
    let selectedService = null;
    let selectedStaff = null;
    let selectedSlot = null;
    let cachedServices = [];
    let cachedStaff = [];
    let lastBookedAppointment = null;

    // --- MODAL CONTROLS ---
    window.openAppointmentsModal = function(preselectedServiceId) {
        const modal = document.getElementById('apptModal');
        const backdrop = document.getElementById('apptModalBackdrop');
        if (!modal || !backdrop) return;

        modal.classList.add('open');
        backdrop.classList.add('open');

        // Set date input min to today
        const dateInput = document.getElementById('apptDateInput');
        if (dateInput) {
            const todayStr = new Date().toISOString().split('T')[0];
            dateInput.min = todayStr;
            if (!dateInput.value) dateInput.value = todayStr;
        }

        loadServicesAndStaff(preselectedServiceId);
    };

    window.closeAppointmentsModal = function() {
        const modal = document.getElementById('apptModal');
        const backdrop = document.getElementById('apptModalBackdrop');
        if (modal) modal.classList.remove('open');
        if (backdrop) backdrop.classList.remove('open');
    };

    window.switchApptTab = function(tab) {
        document.getElementById('tabBtnNewAppt').classList.toggle('active', tab === 'new');
        document.getElementById('tabBtnMyAppts').classList.toggle('active', tab === 'my');
        document.getElementById('paneNewAppt').classList.toggle('active', tab === 'new');
        document.getElementById('paneMyAppts').classList.toggle('active', tab === 'my');
        if (tab === 'my') loadMyAppointments();
    };

    // --- DATA FETCHING ---
    async function loadServicesAndStaff(preselectedServiceId) {
        try {
            const [servRes, staffRes] = await Promise.all([
                fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/services`),
                fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/staff`)
            ]);

            cachedServices = await servRes.json();
            cachedStaff = await staffRes.json();

            renderServices(cachedServices, preselectedServiceId);
            renderStaff(cachedStaff);
        } catch (e) {
            console.error('Error cargando servicios/staff:', e);
        }
    }

    function renderServices(services, preselectedId) {
        const container = document.getElementById('apptServicesContainer');
        if (!container) return;

        if (!services.length) {
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: var(--muted); font-size: 13px;">
                    No hay servicios configurados actualmente en esta tienda.
                </div>
            `;
            return;
        }

        container.innerHTML = services.map(s => `
            <div class="appt-service-card ${preselectedId && s.id == preselectedId ? 'selected' : ''}" 
                 onclick="selectService(${s.id})" id="serviceCard_${s.id}">
                <div>
                    <strong style="font-size: 14px; color: var(--ink); display: block; margin-bottom: 4px;">${s.name}</strong>
                    <p style="font-size: 11.5px; color: var(--muted); margin: 0 0 8px; line-height: 1.4;">
                        ${s.description ? s.description.substring(0, 75) + '...' : 'Servicio profesional garantizado.'}
                    </p>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed var(--line); padding-top: 8px;">
                    <span style="font-size: 12px; color: var(--muted); font-weight: 700;">⏱️ ${s.duration_minutes} min</span>
                    <strong style="font-size: 14px; color: var(--accent);">$${parseFloat(s.price).toFixed(2)} MXN</strong>
                </div>
            </div>
        `).join('');

        if (preselectedId) {
            selectService(preselectedId);
        }
    }

    window.selectService = function(serviceId) {
        selectedService = cachedServices.find(s => s.id == serviceId);
        document.querySelectorAll('.appt-service-card').forEach(c => c.classList.remove('selected'));
        const el = document.getElementById(`serviceCard_${serviceId}`);
        if (el) el.classList.add('selected');
    };

    function renderStaff(staff) {
        const container = document.getElementById('apptStaffContainer');
        if (!container) return;

        let html = `
            <div class="appt-staff-card selected" onclick="selectStaff(null)" id="staffCard_any">
                <div class="appt-staff-avatar" style="display: grid; place-items: center; background: rgba(217, 107, 69, 0.1); color: var(--accent); font-size: 24px;">
                    ⚡
                </div>
                <strong style="display: block; font-size: 13px; color: var(--ink);">Cualquier Especialista</strong>
                <small style="color: var(--muted); font-size: 11px;">Primer horario disponible</small>
            </div>
        `;

        html += staff.map(st => `
            <div class="appt-staff-card" onclick="selectStaff(${st.id})" id="staffCard_${st.id}">
                <img src="${st.photo_url || '/app-icons/icon-192.png'}" alt="${st.name}" class="appt-staff-avatar" onerror="this.src='/app-icons/icon-192.png'">
                <strong style="display: block; font-size: 13px; color: var(--ink);">${st.name}</strong>
                <small style="color: var(--accent); font-weight: 700; font-size: 11px;">${st.role}</small>
            </div>
        `).join('');

        container.innerHTML = html;
        selectedStaff = null; // Default: anyone
    }

    window.selectStaff = function(staffId) {
        selectedStaff = staffId ? cachedStaff.find(s => s.id == staffId) : null;
        document.querySelectorAll('.appt-staff-card').forEach(c => c.classList.remove('selected'));
        const el = document.getElementById(staffId ? `staffCard_${staffId}` : 'staffCard_any');
        if (el) el.classList.add('selected');
    };

    // --- STEP NAVIGATION ---
    window.nextApptStep = function() {
        if (currentStep === 1) {
            if (!selectedService) {
                alert('Por favor selecciona un servicio para continuar.');
                return;
            }
            goToStep(2);
        } else if (currentStep === 2) {
            goToStep(3);
            fetchAvailableSlots();
        } else if (currentStep === 3) {
            if (!selectedSlot) {
                alert('Por favor selecciona un horario disponible.');
                return;
            }
            updateSummaryCard();
            goToStep(4);
        }
    };

    window.prevApptStep = function() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    };

    function goToStep(step) {
        currentStep = step;
        for (let i = 1; i <= 4; i++) {
            const stepBox = document.getElementById(`stepBox${i}`);
            const stepInd = document.getElementById(`stepInd${i}`);
            if (stepBox) stepBox.classList.toggle('active', i === step);
            if (stepInd) stepInd.classList.toggle('active', i === step);
        }

        const backBtn = document.getElementById('btnApptBack');
        const nextBtn = document.getElementById('btnApptNext');
        const submitBtn = document.getElementById('btnApptSubmit');

        if (backBtn) backBtn.style.display = (step > 1) ? 'inline-block' : 'none';
        if (nextBtn) nextBtn.style.display = (step < 4) ? 'inline-block' : 'none';
        if (submitBtn) submitBtn.style.display = (step === 4) ? 'inline-block' : 'none';
    }

    window.fetchAvailableSlots = async function() {
        const date = document.getElementById('apptDateInput')?.value;
        const container = document.getElementById('apptSlotsContainer');
        if (!date || !container) return;

        container.innerHTML = '<div style="text-align: center; color: var(--muted); padding: 15px;">Consultando disponibilidad...</div>';

        try {
            const staffParam = selectedStaff ? `&staff_id=${selectedStaff.id}` : (cachedStaff[0] ? `&staff_id=${cachedStaff[0].id}` : '');
            const servParam = selectedService ? `&service_id=${selectedService.id}` : '';
            const res = await fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/appointments/available-slots?date=${date}${staffParam}${servParam}`);
            const data = await res.json();

            if (!data.slots || !data.slots.length) {
                container.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: var(--muted); font-size: 13px;">
                        No hay horarios libres para esta fecha. Intenta con otro día.
                    </div>
                `;
                return;
            }

            container.innerHTML = data.slots.map(s => `
                <button type="button" class="appt-slot-btn" onclick="selectSlot('${s.datetime}', '${s.label}')" id="slotBtn_${s.time.replace(':', '')}">
                    ${s.label}
                </button>
            `).join('');
            selectedSlot = null;
        } catch (e) {
            container.innerHTML = '<div style="color: red; text-align: center;">Error al cargar horarios.</div>';
        }
    };

    window.selectSlot = function(datetime, label) {
        selectedSlot = { datetime, label };
        document.querySelectorAll('.appt-slot-btn').forEach(b => b.classList.remove('selected'));
        event.currentTarget.classList.add('selected');
    };

    function updateSummaryCard() {
        const card = document.getElementById('apptSummaryCard');
        if (!card) return;

        const staffName = selectedStaff ? selectedStaff.name : (cachedStaff[0] ? cachedStaff[0].name : 'Especialista de Turno');
        card.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <strong style="color: var(--accent); font-size: 14px;">${selectedService?.name || 'Servicio'}</strong>
                <strong style="color: var(--ink);">$${parseFloat(selectedService?.price || 0).toFixed(2)} MXN</strong>
            </div>
            <div style="font-size: 12px; color: var(--muted);">
                <span>👤 Especialista: <strong>${staffName}</strong></span> · 
                <span>⏱️ Duración: <strong>${selectedService?.duration_minutes || 30} min</strong></span>
            </div>
            <div style="font-size: 12.5px; font-weight: 700; color: var(--ink); margin-top: 6px;">
                📅 Horario: ${selectedSlot?.label} (${document.getElementById('apptDateInput')?.value})
            </div>
        `;
    }

    // --- FORM SUBMIT ---
    window.submitAppointmentForm = async function(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('btnApptSubmit');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = '⏳ Reservando cita...';
        }

        const staffId = selectedStaff ? selectedStaff.id : (cachedStaff[0] ? cachedStaff[0].id : 1);

        const payload = {
            service_id: selectedService?.id,
            service_name: selectedService?.name,
            staff_id: staffId,
            scheduled_at: selectedSlot?.datetime,
            customer_name: document.getElementById('apptClientName').value,
            customer_phone: document.getElementById('apptClientPhone').value,
            customer_email: document.getElementById('apptClientEmail').value,
            notes: document.getElementById('apptClientNotes').value,
        };

        try {
            const res = await fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/appointments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (data.success) {
                lastBookedAppointment = data.appointment;
                showSuccessScreen(data.appointment);
                if (typeof showToast === 'function') {
                    showToast('✓ ¡Cita confirmada exitosamente!');
                }
            } else {
                alert(data.message || 'Error al agendar cita');
            }
        } catch (err) {
            alert('Error de conexión al reservar: ' + err.message);
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = '✓ Confirmar y Reservar Cita';
            }
        }
    };

    function showSuccessScreen(appt) {
        document.getElementById('appointmentBookingForm').style.display = 'none';
        const screen = document.getElementById('apptSuccessScreen');
        screen.style.display = 'block';

        const content = document.getElementById('apptTicketContent');
        if (content) {
            content.innerHTML = `
                <div style="background: var(--paper); border: 1.5px dashed var(--line); border-radius: 14px; padding: 18px; text-align: left; font-size: 13px;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--line); padding-bottom: 8px; margin-bottom: 8px;">
                        <span>Folio de Cita:</span>
                        <strong>#CP-${appt.id}</strong>
                    </div>
                    <div style="margin-bottom: 4px;"><strong>Servicio:</strong> ${appt.service_name}</div>
                    <div style="margin-bottom: 4px;"><strong>Especialista:</strong> ${appt.staff ? appt.staff.name : 'Asignado'}</div>
                    <div style="margin-bottom: 4px;"><strong>Fecha y Hora:</strong> ${new Date(appt.scheduled_at).toLocaleString('es-MX')}</div>
                    <div style="margin-bottom: 4px;"><strong>Cliente:</strong> ${appt.customer_name} (${appt.customer_phone})</div>
                    <div style="border-top: 1px solid var(--line); padding-top: 8px; margin-top: 8px; display: flex; justify-content: space-between;">
                        <span>Total:</span>
                        <strong style="color: var(--accent); font-size: 15px;">$${parseFloat(appt.price).toFixed(2)} MXN</strong>
                    </div>
                </div>
            `;
        }
    }

    window.shareApptWhatsApp = function() {
        if (!lastBookedAppointment) return;
        const appt = lastBookedAppointment;
        const msg = encodeURIComponent(
            `¡Hola! Acabo de reservar mi cita en {{ $storeTitle }}.\n` +
            `Folio: #CP-${appt.id}\n` +
            `Servicio: ${appt.service_name}\n` +
            `Horario: ${new Date(appt.scheduled_at).toLocaleString('es-MX')}\n` +
            `Cliente: ${appt.customer_name}`
        );
        window.open(`https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings?->whatsapp_number ?? '') }}?text=${msg}`, '_blank');
    };

    window.loadMyAppointments = async function() {
        const search = document.getElementById('myApptSearchInput')?.value;
        const list = document.getElementById('myAppointmentsList');
        if (!list) return;

        list.innerHTML = '<div style="text-align: center; color: var(--muted); padding: 20px;">Buscando tus citas...</div>';

        try {
            const res = await fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/appointments/my-appointments?email=${encodeURIComponent(search)}&phone=${encodeURIComponent(search)}`);
            const data = await res.json();
            const items = data.data || [];

            if (!items.length) {
                list.innerHTML = '<div style="text-align: center; color: var(--muted); padding: 30px;">No encontramos citas registradas con estos datos.</div>';
                return;
            }

            const statusColors = {
                'pending': '#eab308',
                'confirmed': '#3b82f6',
                'in_service': '#a855f7',
                'completed': '#15803d',
                'cancelled': '#ef4444'
            };

            list.innerHTML = items.map(a => `
                <div style="padding: 14px; border: 1.5px solid var(--card-border); border-radius: 14px; margin-bottom: 10px; background: var(--card);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <strong style="font-size: 14px; color: var(--ink);">${a.service_name}</strong>
                        <span style="font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 999px; background: ${statusColors[a.status] || '#94a3b8'}; color: #fff; text-transform: uppercase;">
                            ${a.status}
                        </span>
                    </div>
                    <div style="font-size: 12px; color: var(--muted);">
                        <span>📅 ${new Date(a.scheduled_at).toLocaleString('es-MX')}</span> · 
                        <span>👤 ${a.staff?.name || 'Especialista'}</span>
                    </div>
                </div>
            `).join('');
        } catch (e) {
            list.innerHTML = '<div style="color: red; text-align: center;">Error al consultar citas.</div>';
        }
    };


    // --- MEMBERSHIPS MODAL CONTROLS ---
    window.openMembershipsModal = function() {
        const modal = document.getElementById('membModal');
        const backdrop = document.getElementById('membModalBackdrop');
        if (!modal || !backdrop) return;

        modal.classList.add('open');
        backdrop.classList.add('open');

        loadMyMembershipCard();
        loadMembershipPlans();
    };

    window.closeMembershipsModal = function() {
        const modal = document.getElementById('membModal');
        const backdrop = document.getElementById('membModalBackdrop');
        if (modal) modal.classList.remove('open');
        if (backdrop) backdrop.classList.remove('open');
    };

    window.switchMembTab = function(tab) {
        document.getElementById('tabBtnMyCard').classList.toggle('active', tab === 'card');
        document.getElementById('tabBtnExplorePlans').classList.toggle('active', tab === 'plans');
        document.getElementById('paneMyCard').classList.toggle('active', tab === 'card');
        document.getElementById('paneExplorePlans').classList.toggle('active', tab === 'plans');
    };

    window.loadMyMembershipCard = async function() {
        const codeOrEmail = document.getElementById('membershipCodeInput')?.value || '';
        const container = document.getElementById('membershipCardContainer');
        if (!container) return;

        container.innerHTML = '<div style="text-align: center; color: var(--muted); padding: 30px;">Consultando membresía...</div>';

        try {
            const isCode = codeOrEmail.toUpperCase().startsWith('MEM-');
            const param = isCode ? `code=${encodeURIComponent(codeOrEmail)}` : `email=${encodeURIComponent(codeOrEmail)}`;
            const res = await fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/memberships/my-card?${param}`);
            const data = await res.json();

            if (!data.has_membership) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 30px; background: var(--paper); border-radius: 18px; border: 1.5px dashed var(--line);">
                        <span style="font-size: 32px; display: block; margin-bottom: 8px;">👑</span>
                        <h4 style="font-size: 15px; font-weight: 800; margin: 0 0 6px;">Aún no tienes una membresía activa</h4>
                        <p style="font-size: 12.5px; color: var(--muted); margin: 0 0 16px;">
                            Descubre nuestros planes para acumular puntos, recibir descuentos y acceso prioritario.
                        </p>
                        <button type="button" class="btn-appt-next" onclick="switchMembTab('plans')">
                            Ver Planes Disponibles
                        </button>
                    </div>
                `;
                return;
            }

            const m = data.membership;
            container.innerHTML = `
                <div class="digital-membership-card">
                    <div class="dmc-shine"></div>
                    <div class="dmc-header">
                        <div>
                            <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; font-weight: 700;">MEMBRESÍA OFICIAL</span>
                            <h3 style="font-size: 20px; font-weight: 800; margin: 2px 0 0; color: #ffffff;">{{ $storeTitle }}</h3>
                        </div>
                        <span class="dmc-badge-pill">${m.plan_name || 'SOCIO VIP'}</span>
                    </div>

                    <div style="font-size: 12px; color: #cbd5e1;">Titular de la Credencial:</div>
                    <div style="font-size: 17px; font-weight: 800; color: #f8fafc;">${m.customer_name}</div>

                    <div class="dmc-code-box">
                        <span>💳</span> <span>${m.code}</span>
                    </div>

                    <div class="dmc-stats-row">
                        <div class="dmc-stat-col">
                            <strong>⭐ ${m.accumulated_points}</strong>
                            <span>Puntos</span>
                        </div>
                        <div class="dmc-stat-col">
                            <strong>${m.visits_used} ${m.visits_included > 0 ? '/ ' + m.visits_included : ''}</strong>
                            <span>Visitas</span>
                        </div>
                        <div class="dmc-stat-col">
                            <strong>${m.days_remaining} d</strong>
                            <span>Vigencia</span>
                        </div>
                    </div>
                </div>

                <!-- Active Perks & Benefits -->
                <div style="background: var(--paper); border: 1.5px solid var(--card-border); border-radius: 16px; padding: 18px; margin-top: 14px;">
                    <h4 style="font-size: 14px; font-weight: 800; margin: 0 0 10px; color: var(--ink);">Tus Beneficios Activos:</h4>
                    <ul style="margin: 0; padding-left: 20px; font-size: 12.5px; color: var(--ink); line-height: 1.7;">
                        ${(m.perks || ['Descuento exclusivo en servicios', 'Atención preferencial']).map(p => `<li>${p}</li>`).join('')}
                    </ul>
                </div>
            `;
        } catch (e) {
            container.innerHTML = '<div style="color: red; text-align: center;">Error al consultar membresía.</div>';
        }
    };

    window.loadMembershipPlans = async function() {
        const container = document.getElementById('membershipPlansContainer');
        if (!container) return;

        try {
            const res = await fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/memberships/plans`);
            const plans = await res.json();

            if (!plans.length) {
                container.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 30px; color: var(--muted);">No hay planes publicados por el momento.</div>';
                return;
            }

            container.innerHTML = plans.map(p => `
                <div class="membership-plan-card">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <h4 style="font-size: 16px; font-weight: 800; margin: 0; color: var(--ink);">${p.name}</h4>
                            <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 999px; background: rgba(217, 107, 69, 0.12); color: var(--accent);">
                                ${p.duration_days} Días
                            </span>
                        </div>
                        <div class="mpc-price">$${parseFloat(p.price).toFixed(2)} MXN</div>
                        <p style="font-size: 12px; color: var(--muted); margin: 0 0 12px;">${p.description || 'Acceso preferencial y acumulación de puntos.'}</p>
                        <ul class="mpc-perks">
                            ${(p.perks || []).map(pk => `<li>${pk}</li>`).join('')}
                        </ul>
                    </div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings?->whatsapp_number ?? '') }}?text=Hola,%20deseo%20adquirir%20la%20membres%C3%ADa%20${encodeURIComponent(p.name)}" 
                       target="_blank" class="btn-appt-next" style="text-align: center; text-decoration: none; display: block;">
                        Solicitar Membresía
                    </a>
                </div>
            `).join('');
        } catch (e) {
            container.innerHTML = '<div style="color: red; text-align: center;">Error al cargar planes.</div>';
        }
    };


    // --- PUSH NOTIFICATIONS CONTROLS ---
    window.enablePushNotifications = async function() {
        if (!('Notification' in window) || !('serviceWorker' in navigator)) {
            alert('Tu navegador no soporta notificaciones push.');
            return;
        }

        try {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                const reg = await navigator.serviceWorker.ready;
                let sub = await reg.pushManager.getSubscription();

                if (!sub) {
                    // Subscribe with dummy/generic application key for WebPush
                    sub = await reg.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: 'BEl62iUYgUivxIkv69yViEuiBIa-Ib9-SkvMeAtA3LFgDzkrxZJjSgSnfckjBJuBkr3qBUYIHBQFLXYp5Nksh8U'
                    });
                }

                // Send to backend
                await fetch(`/api/tienda/${encodeURIComponent(TENANT_ID)}/push/subscribe`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        endpoint: sub.endpoint,
                        user_identifier: '{{ $user->email ?? '' }}'
                    })
                });

                dismissPushBanner();
                if (typeof showToast === 'function') {
                    showToast('🔔 ¡Notificaciones en tiempo real activadas!');
                }
            }
        } catch (e) {
            console.error('Push error:', e);
        }
    };

    window.dismissPushBanner = function() {
        const pill = document.getElementById('pushPermissionPill');
        if (pill) pill.style.display = 'none';
        localStorage.setItem('push_dismissed', '1');
    };

    // Auto-display push banner after 8 seconds if not dismissed
    setTimeout(() => {
        if (!localStorage.getItem('push_dismissed') && 'Notification' in window && Notification.permission === 'default') {
            const pill = document.getElementById('pushPermissionPill');
            if (pill) pill.style.display = 'flex';
        }
    }, 8000);

})();
</script>
