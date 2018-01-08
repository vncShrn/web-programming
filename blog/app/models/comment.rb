class Comment < ApplicationRecord
  belongs_to :article
  validates :body, presence: true,
                    length: { minimum: 3 }
end
