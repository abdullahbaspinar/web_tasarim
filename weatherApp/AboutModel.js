import React from "react";

const AboutModal = () => {
  return (
    <div className="text-center my-4">
      <button
        type="button"
        className="btn btn-info"
        data-bs-toggle="modal"
        data-bs-target="#aboutModal"
      >
        Hakkında
      </button>

      <div className="modal fade" id="aboutModal" tabIndex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
        <div className="modal-dialog">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="aboutModalLabel">Hakkında</h5>
              <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div className="modal-body">
              <p>Bu uygulama, [Adınız] tarafından geliştirilmiştir.</p>
              <p>React ve Bootstrap kullanılarak oluşturulmuştur.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default AboutModal;
